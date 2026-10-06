@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('siswa.index') }}" class="hover:text-slate-900 transition font-medium">Daftar Siswa</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                {{ $siswa->nama }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Profil Siswa</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi lengkap biodata dan riwayat akademik siswa</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('siswa.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
            <x-button variant="accent" :href="route('siswa.edit', $siswa)" class="py-2 px-4 text-xs">
                <x-icon name="edit" class="w-3.5 h-3.5 mr-1" /> Edit Profil
            </x-button>
            <form action="{{ route('siswa.destroy', $siswa) }}" method="POST" class="inline" onsubmit="return confirm('Hapus siswa {{ $siswa->nama }}? Tindakan tidak dapat dibatalkan.')">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit" class="py-2 px-3 text-xs" aria-label="Hapus siswa {{ $siswa->nama }}">
                    <x-icon name="trash" class="w-3.5 h-3.5" />
                </x-button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0">
                {{ strtoupper(substr($siswa->nama, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">{{ $siswa->nama }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span class="font-mono bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/80 text-white font-medium">
                        NIS: {{ $siswa->nis }}
                    </span>
                    <span>&bull;</span>
                    <span>
                        @if($siswa->jenis_kelamin === 'L')
                            Laki-laki
                        @elseif($siswa->jenis_kelamin === 'P')
                            Perempuan
                        @else
                            {{ $siswa->jenis_kelamin ?? '-' }}
                        @endif
                    </span>
                    @if ($siswa->agama)
                        <span>&bull;</span>
                        <span>Agama: {{ $siswa->agama }}</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-5">Biodata & Informasi Kontak</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- NIS -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-nis">NIS</label>
                    <p id="detail-nis" class="text-base font-mono font-bold text-slate-900">{{ $siswa->nis }}</p>
                </div>

                <!-- Nama Lengkap -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-nama">Nama Lengkap</label>
                    <p id="detail-nama" class="text-base font-semibold text-slate-900">{{ $siswa->nama }}</p>
                </div>

                <!-- Jenis Kelamin -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-gender">Jenis Kelamin</label>
                    <p id="detail-gender" class="text-base font-medium text-slate-800">
                        {{ $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                    </p>
                </div>

                <!-- Email -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-email">Email</label>
                    <p id="detail-email" class="text-sm font-medium text-slate-800 truncate">{{ $siswa->email ?? '-' }}</p>
                </div>

                <!-- Nomor HP -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-hp">Nomor Handphone</label>
                    <p id="detail-hp" class="text-sm font-mono font-medium text-slate-800">{{ $siswa->nomor_hp ?? '-' }}</p>
                </div>

                <!-- Agama -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-agama">Agama</label>
                    <p id="detail-agama" class="text-sm font-medium text-slate-800">{{ $siswa->agama ?? '-' }}</p>
                </div>

                <!-- Alamat Domisili -->
                <div class="sm:col-span-2 md:col-span-3 p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-alamat">Alamat Domisili</label>
                    <p id="detail-alamat" class="text-sm text-slate-700 leading-relaxed">{{ $siswa->alamat ?? '-' }}</p>
                </div>
            </div>
        </div>
    </x-card>
@endsection
