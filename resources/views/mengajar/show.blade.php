@extends('layouts.app')

@section('title', 'Detail Penugasan Mengajar')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('mengajar.index') }}" class="hover:text-slate-900 transition font-medium">Penugasan Mengajar</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                #{{ $mengajar->id_mengajar }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Detail Penugasan Guru</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi distribusi mengajar dan alokasi guru per mata pelajaran</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('mengajar.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
            <x-button variant="accent" :href="route('mengajar.edit', $mengajar)" class="py-2 px-4 text-xs">
                <x-icon name="edit" class="w-3.5 h-3.5 mr-1" /> Edit Penugasan
            </x-button>
            <form action="{{ route('mengajar.destroy', $mengajar) }}" method="POST" class="inline" onsubmit="return confirm('Hapus penugasan mengajar ini?')">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit" class="py-2 px-3 text-xs" aria-label="Hapus penugasan #{{ $mengajar->id_mengajar }}">
                    <x-icon name="trash" class="w-3.5 h-3.5" />
                </x-button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0">
                <x-icon name="academic" class="w-8 h-8" />
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">{{ $mengajar->guru?->nama ?? '-' }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span class="font-mono bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/80 text-white font-medium">
                        ID: #{{ $mengajar->id_mengajar }}
                    </span>
                    <span>&bull;</span>
                    <span class="font-semibold text-purple-300">Mapel: {{ $mengajar->mapel?->nama_mapel ?? '-' }}</span>
                    <span>&bull;</span>
                    <span class="font-semibold text-emerald-400">Kelas: {{ $mengajar->kelas?->nama_kelas ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-5">Rincian Penugasan Mengajar</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-guru">Guru Pengajar</label>
                    <p id="detail-guru" class="text-base font-semibold text-slate-900">{{ $mengajar->guru?->nama ?? '-' }}</p>
                    <p class="text-xs text-slate-400 font-mono mt-0.5">NIP: {{ $mengajar->guru?->nip ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-mapel">Mata Pelajaran</label>
                    <p id="detail-mapel" class="text-base font-semibold text-slate-900">{{ $mengajar->mapel?->nama_mapel ?? '-' }}</p>
                    <p class="text-xs text-slate-400 font-mono mt-0.5">Kode: {{ $mengajar->mapel?->kode_mapel ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-kelas">Kelas</label>
                    <p id="detail-kelas" class="text-base font-bold text-slate-900">{{ $mengajar->kelas?->nama_kelas ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-tahun">Tahun Ajaran</label>
                    <p id="detail-tahun" class="text-base font-mono font-medium text-slate-800">{{ $mengajar->tahun_ajaran ?? '-' }}</p>
                </div>
            </div>
        </div>
    </x-card>
@endsection
