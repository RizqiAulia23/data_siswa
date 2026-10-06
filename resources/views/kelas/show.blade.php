@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('kelas.index') }}" class="hover:text-slate-900 transition font-medium">Daftar Kelas</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                {{ $kelas->nama_kelas ?? 'Detail Kelas' }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Profil Kelas</h1>
            <p class="text-sm text-slate-500 mt-1">Informasi lengkap kelas, siswa terdaftar, dan pengajar</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('kelas.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
            <x-button variant="accent" :href="route('kelas.edit', $kelas)" class="py-2 px-4 text-xs">
                <x-icon name="edit" class="w-3.5 h-3.5 mr-1" /> Edit Kelas
            </x-button>
            <form action="{{ route('kelas.destroy', $kelas) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kelas {{ $kelas->nama_kelas }}?')">
                @csrf
                @method('DELETE')
                <x-button variant="danger" type="submit" class="py-2 px-3 text-xs" aria-label="Hapus kelas {{ $kelas->nama_kelas }}">
                    <x-icon name="trash" class="w-3.5 h-3.5" />
                </x-button>
            </form>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center font-bold text-2xl text-white shadow-md flex-shrink-0">
                <x-icon name="academic" class="w-8 h-8" />
            </div>
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-white">{{ $kelas->nama_kelas ?? '-' }}</h2>
                <div class="flex flex-wrap items-center gap-3 mt-2 text-xs text-slate-300">
                    <span class="font-mono bg-slate-800 px-2.5 py-1 rounded-md border border-slate-700/80 text-white font-medium">
                        ID: {{ $kelas->id_kelas }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider mb-5">Informasi Kelas</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-id">ID Kelas</label>
                    <p id="detail-id" class="text-base font-mono font-bold text-slate-900">{{ $kelas->id_kelas }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-name">Nama Kelas</label>
                    <p id="detail-name" class="text-base font-semibold text-slate-900">{{ $kelas->nama_kelas ?? '-' }}</p>
                </div>
            </div>
        </div>
    </x-card>

    <!-- Related Data Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Siswa Terdaftar -->
        <x-card class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900">Siswa Terdaftar</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-200/70">
                    {{ $kelas->pendaftaranKelas->count() }} siswa
                </span>
            </div>
            @forelse ($kelas->pendaftaranKelas as $pendaftaran)
                <div class="py-3 border-b border-slate-100 last:border-b-0 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <span class="text-sm font-semibold text-slate-800 block truncate">{{ $pendaftaran->siswa?->nama ?? '-' }}</span>
                        <span class="text-xs text-slate-400 font-mono">NIS: {{ $pendaftaran->nis }}</span>
                    </div>
                    <x-button variant="secondary" :href="route('siswa.show', $pendaftaran->siswa)" class="px-2.5 py-1.5 text-xs flex-shrink-0">
                        <x-icon name="eye" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Detail
                    </x-button>
                </div>
            @empty
                <div class="py-6 text-center">
                    <div class="max-w-xs mx-auto text-center space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                            <x-icon name="users" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Belum Ada Siswa Terdaftar</p>
                            <p class="text-xs text-slate-500 mt-0.5">Daftarkan siswa ke kelas ini untuk menampilkannya di sini.</p>
                        </div>
                        <div class="pt-2">
                            <x-button variant="accent" :href="route('pendaftaran-kelas.create')" class="px-4 py-2 text-xs">
                                <x-icon name="plus" class="w-3.5 h-3.5 mr-1.5" /> Daftarkan Siswa
                            </x-button>
                        </div>
                    </div>
                </div>
            @endforelse
        </x-card>

        <!-- Pengajar -->
        <x-card class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-sm font-bold text-slate-900">Pengajar</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200/70">
                    {{ $kelas->mengajar->count() }} tugasan
                </span>
            </div>
            @forelse ($kelas->mengajar as $mengajar)
                <div class="py-3 border-b border-slate-100 last:border-b-0 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <span class="text-sm font-semibold text-slate-800 block truncate">{{ $mengajar->guru?->nama ?? '-' }}</span>
                        <span class="text-xs text-slate-500">{{ $mengajar->mapel?->nama_mapel ?? '-' }}</span>
                    </div>
                    <x-button variant="secondary" :href="route('guru.show', $mengajar->guru)" class="px-2.5 py-1.5 text-xs flex-shrink-0">
                        <x-icon name="eye" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Detail
                    </x-button>
                </div>
            @empty
                <div class="py-6 text-center">
                    <div class="max-w-xs mx-auto text-center space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                            <x-icon name="academic" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800">Belum Ada Pengajar Ditugaskan</p>
                            <p class="text-xs text-slate-500 mt-0.5">Tugaskan guru untuk mengajar di kelas ini.</p>
                        </div>
                        <div class="pt-2">
                            <x-button variant="accent" :href="route('mengajar.create')" class="px-4 py-2 text-xs">
                                <x-icon name="plus" class="w-3.5 h-3.5 mr-1.5" /> Tambah Penugasan
                            </x-button>
                        </div>
                    </div>
                </div>
            @endforelse
        </x-card>
    </div>
@endsection
