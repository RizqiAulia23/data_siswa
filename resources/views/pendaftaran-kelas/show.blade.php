@extends('layouts.app')

@section('title', 'Detail Pendaftaran Kelas')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('pendaftaran-kelas.index') }}" class="hover:text-slate-900 transition font-medium">Pendaftaran Kelas</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                #{{ $pendaftaranKelas->id }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Detail Pendaftaran Siswa</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi penempatan dan alokasi rombongan belajar siswa</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('pendaftaran-kelas.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
            <x-button variant="accent" :href="route('pendaftaran-kelas.edit', $pendaftaranKelas)" class="py-2 px-4 text-xs">
                <x-icon name="edit" class="w-3.5 h-3.5 mr-1" /> Edit Data
            </x-button>
            <form action="{{ route('pendaftaran-kelas.destroy', $pendaftaranKelas) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pendaftaran ini?')">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit" class="py-2 px-3 text-xs" aria-label="Hapus pendaftaran #{{ $pendaftaranKelas->id }}">
                    <x-icon name="trash" class="w-3.5 h-3.5" />
                </x-button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0">
                <x-icon name="check" class="w-8 h-8" />
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">{{ $pendaftaranKelas->siswa?->nama ?? '-' }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span class="font-mono bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/80 text-white font-medium">
                        NIS: {{ $pendaftaranKelas->nis }}
                    </span>
                    <span>&bull;</span>
                    <span class="font-semibold text-emerald-400">Kelas: {{ $pendaftaranKelas->kelas?->nama_kelas ?? '-' }}</span>
                    <span>&bull;</span>
                    <span>Tahun: {{ $pendaftaranKelas->tahun ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-5">Data Penempatan Rombel</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-id">ID Pendaftaran</label>
                    <p id="detail-id" class="text-base font-mono font-bold text-slate-900">#{{ $pendaftaranKelas->id }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-siswa">Nama Siswa</label>
                    <p id="detail-siswa" class="text-base font-semibold text-slate-900">{{ $pendaftaranKelas->siswa?->nama ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-nis">NIS Siswa</label>
                    <p id="detail-nis" class="text-base font-mono font-medium text-slate-800">{{ $pendaftaranKelas->nis }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-kelas">Kelas Alokasi</label>
                    <p id="detail-kelas" class="text-base font-bold text-slate-900">{{ $pendaftaranKelas->kelas?->nama_kelas ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-tahun">Tahun Angkatan</label>
                    <p id="detail-tahun" class="text-base font-mono font-medium text-slate-800">{{ $pendaftaranKelas->tahun ?? '-' }}</p>
                </div>
            </div>
        </div>
    </x-card>
@endsection
