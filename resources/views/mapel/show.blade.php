@extends('layouts.app')

@section('title', 'Detail Mata Pelajaran')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('mapel.index') }}" class="hover:text-slate-900 transition font-medium">Daftar Mapel</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                {{ $mapel->nama_mapel }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Profil Mata Pelajaran</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi kurikulum, jam, dan deskripsi mata pelajaran</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('mapel.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
            <x-button variant="accent" :href="route('mapel.edit', $mapel)" class="py-2 px-4 text-xs">
                <x-icon name="edit" class="w-3.5 h-3.5 mr-1" /> Edit Mapel
            </x-button>
            <form action="{{ route('mapel.destroy', $mapel) }}" method="POST" class="inline" onsubmit="return confirm('Hapus mapel {{ $mapel->nama_mapel }}?')">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit" class="py-2 px-3 text-xs" aria-label="Hapus mapel {{ $mapel->nama_mapel }}">
                    <x-icon name="trash" class="w-3.5 h-3.5" />
                </x-button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0">
                <x-icon name="book" class="w-8 h-8" />
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">{{ $mapel->nama_mapel }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span class="font-mono bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/80 text-white font-medium">
                        Kode: {{ $mapel->kode_mapel }}
                    </span>
                    <span>&bull;</span>
                    <span>{{ $mapel->kategori ?? 'Umum' }}</span>
                </div>
            </div>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-5">Informasi Kurikulum</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-jam">Jumlah Jam</label>
                    <p id="detail-jam" class="text-base font-bold text-slate-900">{{ $mapel->jumlah_jam }} Jam</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-kktp">Nilai KKT</label>
                    <p id="detail-kktp" class="text-base font-bold text-slate-900">{{ $mapel->nilai_kktp ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-semester">Semester</label>
                    <p id="detail-semester" class="text-base font-medium text-slate-800">{{ $mapel->semester ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-status">Status</label>
                    <p id="detail-status" class="text-base font-medium text-slate-800">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $mapel->aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-slate-100 text-slate-600 border border-slate-200/70' }}">
                            {{ $mapel->aktif ? 'Aktif' : 'Non-Aktif' }}
                        </span>
                    </p>
                </div>
                <div class="sm:col-span-2 md:col-span-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-desc">Deskripsi</label>
                    <p id="detail-desc" class="text-sm text-slate-700 leading-relaxed">{{ $mapel->deskripsi ?? 'Tanpa deskripsi' }}</p>
                </div>
            </div>
        </div>
    </x-card>
@endsection
