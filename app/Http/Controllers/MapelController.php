<?php

namespace App\Http\Controllers;

use App\Http\Requests\MapelRequest;
use App\Models\Mapel;
use App\Support\ActivityLogHelper;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class MapelController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $this->authorize('viewAny', Mapel::class);

        $mapel = Mapel::orderBy('nama_mapel')->paginate(10);

        return view('mapel.index', compact('mapel'));
    }

    public function create(): View
    {
        $this->authorize('create', Mapel::class);

        return view('mapel.create');
    }

    public function store(MapelRequest $request): RedirectResponse
    {
        $mapel = Mapel::create($request->validated());

        ActivityLogHelper::log("Data mapel ditambahkan: {$mapel->nama_mapel}", 'INSERT');

        return Redirect::route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function show(Mapel $mapel): View
    {
        $this->authorize('view', $mapel);

        return view('mapel.show', compact('mapel'));
    }

    public function edit(Mapel $mapel): View
    {
        $this->authorize('update', $mapel);

        return view('mapel.edit', compact('mapel'));
    }

    public function update(MapelRequest $request, Mapel $mapel): RedirectResponse
    {
        $mapel->update($request->validated());

        ActivityLogHelper::log("Data mapel diperbarui: {$mapel->nama_mapel}", 'UPDATE');

        return Redirect::route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel): RedirectResponse
    {
        $this->authorize('delete', $mapel);

        try {
            $deleted = DB::transaction(function () use ($mapel) {
                $target = Mapel::where('id_mapel', $mapel->id_mapel)->lockForUpdate()->first();

                if (! $target) {
                    return false;
                }

                if ($target->mengajar()->exists() || $target->nilai()->exists()) {
                    return false;
                }

                $nama = $target->nama_mapel;
                $target->delete();

                ActivityLogHelper::log("Data mapel dihapus: {$nama}", 'DELETE');

                return true;
            });

            if (! $deleted) {
                return Redirect::route('mapel.index')
                    ->with('error', 'Mata pelajaran tidak dapat dihapus karena masih memiliki data mengajar atau nilai terkait.');
            }

            return Redirect::route('mapel.index')
                ->with('success', 'Mata pelajaran berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::route('mapel.index')
                ->with('error', 'Mata pelajaran tidak dapat dihapus karena ada referensi di tabel lain.');
        }
    }
}
