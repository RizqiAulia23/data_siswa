<?php

namespace App\Http\Controllers;

use App\Http\Requests\PendaftaranKelasRequest;
use App\Models\Kelas;
use App\Models\PendaftaranKelas;
use App\Models\Siswa;
use App\Support\ActivityLogHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PendaftaranKelasController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', PendaftaranKelas::class);

        $pendaftaranKelas = PendaftaranKelas::with(['siswa', 'kelas'])
            ->latest('id')
            ->paginate(10);

        return view('pendaftaran-kelas.index', compact('pendaftaranKelas'));
    }

    public function create(): View
    {
        $this->authorize('create', PendaftaranKelas::class);

        $siswa = Siswa::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('pendaftaran-kelas.create', compact('siswa', 'kelas'));
    }

    public function store(PendaftaranKelasRequest $request): RedirectResponse
    {
        $pendaftaran = PendaftaranKelas::create($request->validated());

        ActivityLogHelper::log("Pendaftaran kelas dibuat ID: {$pendaftaran->id}", 'INSERT');

        return Redirect::route('pendaftaran-kelas.index')
            ->with('success', 'Pendaftaran kelas berhasil ditambahkan.');
    }

    public function show(PendaftaranKelas $pendaftaranKelas): View
    {
        $this->authorize('view', $pendaftaranKelas);

        $pendaftaranKelas->load(['siswa', 'kelas']);

        return view('pendaftaran-kelas.show', compact('pendaftaranKelas'));
    }

    public function edit(PendaftaranKelas $pendaftaranKelas): View
    {
        $this->authorize('update', $pendaftaranKelas);

        $siswa = Siswa::orderBy('nama')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('pendaftaran-kelas.edit', compact('pendaftaranKelas', 'siswa', 'kelas'));
    }

    public function update(PendaftaranKelasRequest $request, PendaftaranKelas $pendaftaranKelas): RedirectResponse
    {
        $pendaftaranKelas->update($request->validated());

        ActivityLogHelper::log("Pendaftaran kelas diperbarui ID: {$pendaftaranKelas->id}", 'UPDATE');

        return Redirect::route('pendaftaran-kelas.index')
            ->with('success', 'Pendaftaran kelas berhasil diperbarui.');
    }

    public function destroy(PendaftaranKelas $pendaftaranKelas): RedirectResponse
    {
        $this->authorize('delete', $pendaftaranKelas);

        $id = $pendaftaranKelas->id;
        $pendaftaranKelas->delete();

        ActivityLogHelper::log("Pendaftaran kelas dihapus ID: {$id}", 'DELETE');

        return Redirect::route('pendaftaran-kelas.index')
            ->with('success', 'Pendaftaran kelas berhasil dihapus.');
    }
}
