@extends('layouts.app')

@section('title', 'Detail Guru')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('guru.index') }}" class="hover:text-slate-900 transition font-medium">Daftar Guru</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                {{ $guru->nama ?? 'Detail Guru' }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Profil Guru Pengajar</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi kepegawaian dan biodata tenaga pengajar</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('guru.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
            <x-button variant="accent" :href="route('guru.edit', $guru)" class="py-2 px-4 text-xs">
                <x-icon name="edit" class="w-3.5 h-3.5 mr-1" /> Edit Profil
            </x-button>
            <form action="{{ route('guru.destroy', $guru) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data guru {{ $guru->nama }}?')">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit" class="py-2 px-3 text-xs" aria-label="Hapus guru {{ $guru->nama }}">
                    <x-icon name="trash" class="w-3.5 h-3.5" />
                </x-button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0">
                {{ strtoupper(substr($guru->nama ?? 'G', 0, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">{{ $guru->nama ?? '-' }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span class="font-mono bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/80 text-white font-medium">
                        NIP: {{ $guru->nip ?? '-' }}
                    </span>
                    <span>&bull;</span>
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold {{ $guru->aktif ? 'bg-emerald-500/20 text-emerald-300' : 'bg-slate-700 text-slate-300' }}">
                        {{ $guru->aktif ? 'Status: Aktif' : 'Status: Non-Aktif' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-5">Informasi Kepegawaian & Kontak</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- NIP -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-nip">NIP</label>
                    <p id="detail-nip" class="text-base font-mono font-bold text-slate-900">{{ $guru->nip ?? '-' }}</p>
                </div>

                <!-- Nama Lengkap -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-nama">Nama Lengkap</label>
                    <p id="detail-nama" class="text-base font-semibold text-slate-900">{{ $guru->nama ?? '-' }}</p>
                </div>

                <!-- Jenis Kelamin -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-gender">Jenis Kelamin</label>
                    <p id="detail-gender" class="text-base font-medium text-slate-800">
                        {{ $guru->jenis_kelamin === 'L' ? 'Laki-laki' : ($guru->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                    </p>
                </div>

                <!-- Tanggal Lahir -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-lahir">Tanggal Lahir</label>
                    <p id="detail-lahir" class="text-sm font-medium text-slate-800">
                        {{ $guru->tanggal_lahir ? $guru->tanggal_lahir->format('d F Y') : '-' }}
                    </p>
                </div>

                <!-- Jam Masuk -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-jam">Jam Masuk</label>
                    <p id="detail-jam" class="text-sm font-mono font-medium text-slate-800">{{ $guru->jam_masuk ?? '-' }}</p>
                </div>

                <!-- Nomor HP -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-hp">Nomor Handphone</label>
                    <p id="detail-hp" class="text-sm font-mono font-medium text-slate-800">{{ $guru->nomor_hp ?? '-' }}</p>
                </div>

                @can('viewSalary', $guru)
                    <!-- Gaji (Authorized Only) -->
                    <div class="p-4 rounded-xl bg-emerald-50/50 border border-emerald-200/80">
                        <label class="block text-[11px] font-bold uppercase tracking-wider text-emerald-800 mb-1" for="detail-gaji">Informasi Gaji</label>
                        <p id="detail-gaji" class="text-base font-bold text-emerald-950 font-mono">
                            {{ $guru->gaji ? 'Rp ' . number_format($guru->gaji, 2, ',', '.') : '-' }}
                        </p>
                    </div>
                @endcan

                <!-- Alamat Domisili -->
                <div class="sm:col-span-2 md:col-span-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-alamat">Alamat Domisili</label>
                    <p id="detail-alamat" class="text-sm text-slate-700 leading-relaxed">{{ $guru->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>
    </x-card>
@endsection
