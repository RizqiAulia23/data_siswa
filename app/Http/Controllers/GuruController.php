<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuruRequest;
use App\Models\Guru;
use App\Support\ActivityLogHelper;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class GuruController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Guru::class);

        $guru = Guru::orderBy('nama')->paginate(10);

        return view('guru.index', compact('guru'));
    }

    public function create(): View
    {
        $this->authorize('create', Guru::class);

        return view('guru.create');
    }

    public function store(GuruRequest $request): RedirectResponse
    {
        $guru = Guru::create($request->validated());

        ActivityLogHelper::log("Data guru ditambahkan: {$guru->nama}", 'INSERT');

        return Redirect::route('guru.index')
            ->with('success', 'Guru berhasil ditambahkan.');
    }

    public function show(Guru $guru): View
    {
        $this->authorize('view', $guru);

        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru): View
    {
        $this->authorize('update', $guru);

        return view('guru.edit', compact('guru'));
    }

    public function update(GuruRequest $request, Guru $guru): RedirectResponse
    {
        $guru->update($request->validated());

        ActivityLogHelper::log("Data guru diperbarui: {$guru->nama}", 'UPDATE');

        return Redirect::route('guru.index')
            ->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru): RedirectResponse
    {
        $this->authorize('delete', $guru);

        try {
            $deleted = DB::transaction(function () use ($guru) {
                $target = Guru::where('id_guru', $guru->id_guru)->lockForUpdate()->first();

                if (! $target) {
                    return false;
                }

                if ($target->mengajar()->exists()) {
                    return false;
                }

                $nama = $target->nama;
                $target->delete();

                ActivityLogHelper::log("Data guru dihapus: {$nama}", 'DELETE');

                return true;
            });

            if (! $deleted) {
                return Redirect::route('guru.index')
                    ->with('error', 'Guru tidak dapat dihapus karena masih memiliki data mengajar terkait.');
            }

            return Redirect::route('guru.index')
                ->with('success', 'Guru berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::route('guru.index')
                ->with('error', 'Guru tidak dapat dihapus karena ada referensi di tabel lain.');
        }
    }
}
