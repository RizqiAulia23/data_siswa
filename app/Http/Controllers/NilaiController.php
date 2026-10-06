<?php

namespace App\Http\Controllers;

use App\Http\Requests\NilaiRequest;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use App\Support\ActivityLogHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class NilaiController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Nilai::class);

        $nilai = Nilai::with(['siswa', 'mapel'])
            ->latest('id_nilai')
            ->paginate(10);

        return view('nilai.index', compact('nilai'));
    }

    public function create(): View
    {
        $this->authorize('create', Nilai::class);

        $siswa = Siswa::orderBy('nama')->get();
        $mapel = Mapel::orderBy('nama_mapel')->get();

        return view('nilai.create', compact('siswa', 'mapel'));
    }

    public function store(NilaiRequest $request): RedirectResponse
    {
        $nilai = Nilai::create($request->validated());

        ActivityLogHelper::log("Nilai ditambahkan ID: {$nilai->id_nilai}", 'INSERT');

        return Redirect::route('nilai.index')
            ->with('success', 'Data nilai berhasil ditambahkan.');
    }

    public function show(Nilai $nilai): View
    {
        $this->authorize('view', $nilai);

        $nilai->load(['siswa', 'mapel']);

        return view('nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai): View
    {
        $this->authorize('update', $nilai);

        $siswa = Siswa::orderBy('nama')->get();
        $mapel = Mapel::orderBy('nama_mapel')->get();

        return view('nilai.edit', compact('nilai', 'siswa', 'mapel'));
    }

    public function update(NilaiRequest $request, Nilai $nilai): RedirectResponse
    {
        $nilai->update($request->validated());

        ActivityLogHelper::log("Nilai diperbarui ID: {$nilai->id_nilai}", 'UPDATE');

        return Redirect::route('nilai.index')
            ->with('success', 'Data nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai): RedirectResponse
    {
        $this->authorize('delete', $nilai);

        $id = $nilai->id_nilai;
        $nilai->delete();

        ActivityLogHelper::log("Nilai dihapus ID: {$id}", 'DELETE');

        return Redirect::route('nilai.index')
            ->with('success', 'Data nilai berhasil dihapus.');
    }
}
