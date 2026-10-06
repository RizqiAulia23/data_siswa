@extends('layouts.app')

@section('title', 'Detail Data Nilai')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('nilai.index') }}" class="hover:text-slate-900 transition font-medium">Daftar Nilai</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                {{ $nilai->siswa?->nama ?? 'Detail' }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Detail Nilai Siswa</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi lengkap nilai dan prestasi akademik siswa</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('nilai.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
            <x-button variant="accent" :href="route('nilai.edit', $nilai)" class="py-2 px-4 text-xs">
                <x-icon name="edit" class="w-3.5 h-3.5 mr-1" /> Edit Nilai
            </x-button>
            <form action="{{ route('nilai.destroy', $nilai) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data nilai ini?')">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit" class="py-2 px-3 text-xs" aria-label="Hapus nilai siswa {{ $nilai->siswa?->nama }}">
                    <x-icon name="trash" class="w-3.5 h-3.5" />
                </x-button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-rose-500 to-pink-600 flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0">
                {{ strtoupper(substr($nilai->siswa?->nama ?? 'N', 0, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">{{ $nilai->siswa?->nama ?? '-' }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span class="font-mono bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/80 text-white font-medium">
                        NIS: {{ $nilai->nis }}
                    </span>
                    <span>&bull;</span>
                    <span class="font-semibold text-blue-300">{{ $nilai->mapel?->nama_mapel ?? '-' }}</span>
                    <span>&bull;</span>
                    <span class="font-semibold text-emerald-300">S{{ $nilai->semester ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Nilai Display -->
        <div class="p-6 sm:p-8 bg-slate-50 border-b border-slate-200 flex flex-col sm:flex-row items-center justify-center gap-8">
            <div class="text-center">
                <div class="text-7xl font-extrabold text-slate-900 tracking-tight leading-none">
                    {{ $nilai->nilai ?? '-' }}
                </div>
                <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mt-2">
                    @if ($nilai->nilai >= 85)
                        Sangat Baik
                    @elseif ($nilai->nilai >= 75)
                        Baik
                    @elseif ($nilai->nilai >= 60)
                        Cukup
                    @else
                        Perlu Perhatian
                    @endif
                </div>
            </div>
            <div class="flex flex-col gap-3">
                <div class="p-4 rounded-xl bg-white border border-slate-200 text-center">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Semester</div>
                    <div class="text-lg font-bold text-slate-900">S{{ $nilai->semester ?? '-' }}</div>
                </div>
                <div class="p-4 rounded-xl bg-white border border-slate-200 text-center">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-1">Mata Pelajaran</div>
                    <div class="text-lg font-bold text-slate-900">{{ $nilai->mapel?->nama_mapel ?? '-' }}</div>
                </div>
            </div>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-5">Data Pendukung</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-siswa">Siswa</label>
                    <p id="detail-siswa" class="text-base font-semibold text-slate-900">{{ $nilai->siswa?->nama ?? '-' }}</p>
                    <p class="text-sm text-slate-500 font-mono">NIS: {{ $nilai->nis ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-mapel">Mata Pelajaran</label>
                    <p id="detail-mapel" class="text-base font-semibold text-slate-900">{{ $nilai->mapel?->nama_mapel ?? '-' }}</p>
                    <p class="text-sm text-slate-500 font-mono">Kode: {{ $nilai->mapel?->kode_mapel ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-semester">Semester</label>
                    <p id="detail-semester" class="text-base font-medium text-slate-800">{{ $nilai->semester ?? '-' }}</p>
                </div>
            </div>
        </div>
    </x-card>
@endsection
