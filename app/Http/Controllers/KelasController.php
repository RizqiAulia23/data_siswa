<?php

namespace App\Http\Controllers;

use App\Http\Requests\KelasRequest;
use App\Models\Kelas;
use App\Support\ActivityLogHelper;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class KelasController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Kelas::class);

        $kelas = Kelas::orderBy('nama_kelas')->paginate(10);

        return view('kelas.index', compact('kelas'));
    }

    public function create(): View
    {
        $this->authorize('create', Kelas::class);

        return view('kelas.create');
    }

    public function store(KelasRequest $request): RedirectResponse
    {
        $kelas = Kelas::create($request->validated());

        ActivityLogHelper::log("Data kelas ditambahkan: {$kelas->nama_kelas}", 'INSERT');

        return Redirect::route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function show(Kelas $kelas): View
    {
        $this->authorize('view', $kelas);

        $kelas->load(['pendaftaranKelas.siswa', 'mengajar.guru', 'mengajar.mapel']);

        return view('kelas.show', compact('kelas'));
    }

    public function edit(Kelas $kelas): View
    {
        $this->authorize('update', $kelas);

        return view('kelas.edit', compact('kelas'));
    }

    public function update(KelasRequest $request, Kelas $kelas): RedirectResponse
    {
        $kelas->update($request->validated());

        ActivityLogHelper::log("Data kelas diperbarui: {$kelas->nama_kelas}", 'UPDATE');

        return Redirect::route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kelas): RedirectResponse
    {
        $this->authorize('delete', $kelas);

        try {
            $deleted = DB::transaction(function () use ($kelas) {
                $target = Kelas::where('id_kelas', $kelas->id_kelas)->lockForUpdate()->first();

                if (! $target) {
                    return false;
                }

                if ($target->pendaftaranKelas()->exists() || $target->mengajar()->exists()) {
                    return false;
                }

                $nama = $target->nama_kelas;
                $target->delete();

                ActivityLogHelper::log("Data kelas dihapus: {$nama}", 'DELETE');

                return true;
            });

            if (! $deleted) {
                return Redirect::route('kelas.index')
                    ->with('error', 'Kelas tidak dapat dihapus karena masih memiliki data pendaftaran atau mengajar terkait.');
            }

            return Redirect::route('kelas.index')
                ->with('success', 'Kelas berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::route('kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena ada referensi di tabel lain.');
        }
    }
}
