<?php

namespace App\Http\Controllers;

use App\Http\Requests\SiswaRequest;
use App\Models\Siswa;
use App\Support\ActivityLogHelper;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class SiswaController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Siswa::class);

        $siswa = Siswa::orderBy('nama')->paginate(10);

        return view('siswa.index', compact('siswa'));
    }

    public function create(): View
    {
        $this->authorize('create', Siswa::class);

        return view('siswa.create');
    }

    public function store(SiswaRequest $request): RedirectResponse
    {
        $siswa = Siswa::create($request->validated());

        ActivityLogHelper::log("Data siswa ditambahkan: {$siswa->nama}", 'INSERT');

        return Redirect::route('siswa.index')
            ->with('success', 'Siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa): View
    {
        $this->authorize('view', $siswa);

        return view('siswa.show', compact('siswa'));
    }

    public function edit(Siswa $siswa): View
    {
        $this->authorize('update', $siswa);

        return view('siswa.edit', compact('siswa'));
    }

    public function update(SiswaRequest $request, Siswa $siswa): RedirectResponse
    {
        $siswa->update($request->validated());

        ActivityLogHelper::log("Data siswa diperbarui: {$siswa->nama}", 'UPDATE');

        return Redirect::route('siswa.index')
            ->with('success', 'Siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa): RedirectResponse
    {
        $this->authorize('delete', $siswa);

        try {
            $deleted = DB::transaction(function () use ($siswa) {
                $target = Siswa::where('nis', $siswa->nis)->lockForUpdate()->first();

                if (! $target) {
                    return false;
                }

                if ($target->pendaftaranKelas()->exists() || $target->nilai()->exists()) {
                    return false;
                }

                $nama = $target->nama;
                $target->delete();

                ActivityLogHelper::log("Data siswa dihapus: {$nama}", 'DELETE');

                return true;
            });

            if (! $deleted) {
                return Redirect::route('siswa.index')
                    ->with('error', 'Siswa tidak dapat dihapus karena masih memiliki data pendaftaran kelas atau nilai terkait.');
            }

            return Redirect::route('siswa.index')
                ->with('success', 'Siswa berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::route('siswa.index')
                ->with('error', 'Siswa tidak dapat dihapus. Data terkait di tabel lain masih merujuk ke siswa ini.');
        }
    }
}
