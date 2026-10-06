<?php

namespace App\Http\Controllers;

use App\Http\Requests\MengajarRequest;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Mengajar;
use App\Support\ActivityLogHelper;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MengajarController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Mengajar::class);

        $mengajar = Mengajar::with(['guru', 'mapel', 'kelas'])
            ->latest('id_mengajar')
            ->paginate(10);

        return view('mengajar.index', compact('mengajar'));
    }

    public function create(): View
    {
        $this->authorize('create', Mengajar::class);

        $guru = Guru::orderBy('nama')->get();
        $mapel = Mapel::orderBy('nama_mapel')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('mengajar.create', compact('guru', 'mapel', 'kelas'));
    }

    public function store(MengajarRequest $request): RedirectResponse
    {
        $mengajar = Mengajar::create($request->validated());

        ActivityLogHelper::log("Penugasan mengajar ditambahkan ID: {$mengajar->id_mengajar}", 'INSERT');

        return Redirect::route('mengajar.index')
            ->with('success', 'Data penugasan mengajar berhasil ditambahkan.');
    }

    public function show(Mengajar $mengajar): View
    {
        $this->authorize('view', $mengajar);

        $mengajar->load(['guru', 'mapel', 'kelas']);

        return view('mengajar.show', compact('mengajar'));
    }

    public function edit(Mengajar $mengajar): View
    {
        $this->authorize('update', $mengajar);

        $guru = Guru::orderBy('nama')->get();
        $mapel = Mapel::orderBy('nama_mapel')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('mengajar.edit', compact('mengajar', 'guru', 'mapel', 'kelas'));
    }

    public function update(MengajarRequest $request, Mengajar $mengajar): RedirectResponse
    {
        $mengajar->update($request->validated());

        ActivityLogHelper::log("Penugasan mengajar diperbarui ID: {$mengajar->id_mengajar}", 'UPDATE');

        return Redirect::route('mengajar.index')
            ->with('success', 'Data penugasan mengajar berhasil diperbarui.');
    }

    public function destroy(Mengajar $mengajar): RedirectResponse
    {
        $this->authorize('delete', $mengajar);

        $id = $mengajar->id_mengajar;
        $mengajar->delete();

        ActivityLogHelper::log("Penugasan mengajar dihapus ID: {$id}", 'DELETE');

        return Redirect::route('mengajar.index')
            ->with('success', 'Data penugasan mengajar berhasil dihapus.');
    }
}
