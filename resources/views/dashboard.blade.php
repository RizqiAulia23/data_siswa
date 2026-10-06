@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Dashboard Hero Header -->
    <x-card class="mb-8 p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-700 text-xs font-semibold mb-2">
                <span>Ringkasan Eksekutif</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">
                Ikhtisar metrik statistik akademik dan log audit sistem terpadu
            </p>
        </div>
        <div class="flex items-center space-x-3 self-start md:self-auto pt-2 md:pt-0">
            <div class="px-3.5 py-2 rounded-xl bg-slate-50 border border-slate-200/80 text-xs font-medium text-slate-700">
                <span class="text-slate-400 mr-1">Peran:</span>
                <span class="font-bold text-slate-900 uppercase">{{ Auth::user()->role ?? 'Admin' }}</span>
            </div>
        </div>
    </x-card>

    <!-- 8 Statistical Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
        <!-- 1. Total Siswa -->
        <a href="{{ route('siswa.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-blue-200 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-blue-600 transition-colors">Total Siswa</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalSiswa) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 group-hover:text-white transition-all duration-150">
                        <x-icon name="users" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Kelola Master Siswa</span>
                    <span class="text-blue-600 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>

        <!-- 2. Total Guru -->
        <a href="{{ route('guru.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-slate-300 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-slate-900 transition-colors">Total Guru</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalGuru) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0 group-hover:bg-slate-900 group-hover:text-white transition-all duration-150">
                        <x-icon name="user-plus" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Kelola Master Guru</span>
                    <span class="text-slate-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>

        <!-- 3. Total Kelas -->
        <a href="{{ route('kelas.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-emerald-200 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-emerald-700 transition-colors">Total Kelas</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalKelas) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-150">
                        <x-icon name="academic" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Ruang & Tingkatan</span>
                    <span class="text-emerald-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>

        <!-- 4. Total Mata Pelajaran -->
        <a href="{{ route('mapel.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-amber-200 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-amber-700 transition-colors">Mata Pelajaran</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalMapel) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all duration-150">
                        <x-icon name="book" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Kurikulum & Jam</span>
                    <span class="text-amber-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>

        <!-- 5. Pendaftaran Kelas -->
        <a href="{{ route('pendaftaran-kelas.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-sky-200 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-sky-700 transition-colors">Pendaftaran Kelas</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalPendaftaranKelas) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center flex-shrink-0 group-hover:bg-sky-600 group-hover:text-white transition-all duration-150">
                        <x-icon name="check" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Penempatan Siswa</span>
                    <span class="text-sky-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>

        <!-- 6. Penugasan Mengajar -->
        <a href="{{ route('mengajar.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-purple-200 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-purple-700 transition-colors">Penugasan Mengajar</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalMengajar) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-600 group-hover:text-white transition-all duration-150">
                        <x-icon name="academic" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Distribusi Pengajar</span>
                    <span class="text-purple-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>

        <!-- 7. Total Nilai -->
        <a href="{{ route('nilai.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-rose-200 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-rose-700 transition-colors">Total Nilai</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalNilai) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 group-hover:bg-rose-600 group-hover:text-white transition-all duration-150">
                        <x-icon name="chart" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Rekapitulasi Nilai</span>
                    <span class="text-rose-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>

        <!-- 8. Log Aktivitas -->
        <a href="{{ route('log-aktivitas.index') }}" class="group block focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl">
            <x-card class="hover:shadow-md hover:border-slate-300 transition-all duration-150 h-full flex flex-col justify-between p-5 cursor-pointer">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-slate-600 group-hover:text-slate-900 transition-colors">Log Aktivitas</p>
                        <p class="text-3xl font-extrabold text-slate-900 tracking-tight mt-1.5">{{ number_format($totalLogAktivitas) }}</p>
                    </div>
                    <div class="w-11 h-11 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center flex-shrink-0 group-hover:bg-slate-900 group-hover:text-white transition-all duration-150">
                        <x-icon name="clock" class="w-5 h-5" />
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-600 font-medium">
                    <span>Audit Trail Sistem</span>
                    <span class="text-slate-700 group-hover:translate-x-0.5 transition-transform">&rarr;</span>
                </div>
            </x-card>
        </a>
    </div>

    <!-- 2 Kolom Berdampingan: Siswa Terbaru & Log Aktivitas -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Card 1: Siswa Terbaru -->
        <x-card class="overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Siswa Terbaru</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Daftar siswa terbaru yang terdaftar di sistem</p>
                    </div>
                    <a href="{{ route('siswa.index') }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                        Lihat Semua <span class="ml-1">&rarr;</span>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left">NIS</th>
                                <th scope="col" class="px-6 py-3.5 text-left">Nama Siswa</th>
                                <th scope="col" class="px-6 py-3.5 text-center">L/P</th>
                                <th scope="col" class="px-6 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentSiswa as $s)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-4 font-mono font-semibold text-slate-700">{{ $s->nis }}</td>
                                    <td class="px-6 py-4 font-medium text-slate-900">{{ $s->nama }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if ($s->jenis_kelamin === 'L')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">L</span>
                                        @elseif ($s->jenis_kelamin === 'P')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700">P</span>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('siswa.show', $s) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="max-w-xs mx-auto text-center space-y-3">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                                <x-icon name="users" class="w-6 h-6" />
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">Belum Ada Data Siswa</p>
                                                <p class="text-xs text-slate-500 mt-0.5">Siswa yang baru ditambahkan akan muncul di sini</p>
                                            </div>
                                            <div class="pt-2">
                                                <x-button variant="accent" :href="route('siswa.create')" class="px-4 py-2 text-xs">
                                                    <x-icon name="user-plus" class="w-3.5 h-3.5 mr-1.5" /> Tambah Siswa Pertama
                                                </x-button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>

        <!-- Card 2: Log Aktivitas Terbaru -->
        <x-card class="overflow-hidden flex flex-col justify-between">
            <div>
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Aktivitas Terbaru</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Catatan audit trail aktivitas sistem</p>
                    </div>
                    <a href="{{ route('log-aktivitas.index') }}" class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                        Lihat Semua <span class="ml-1">&rarr;</span>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50/80 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-600">
                            <tr>
                                <th scope="col" class="px-6 py-3.5 text-left">Waktu</th>
                                <th scope="col" class="px-6 py-3.5 text-center">Tipe</th>
                                <th scope="col" class="px-6 py-3.5 text-left">Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentLog as $l)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-4 font-mono text-[11px] text-slate-500 whitespace-nowrap">
                                        {{ $l->waktu ? $l->waktu->format('d/m H:i') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        @php
                                            $actionBadgeClass = match (strtoupper($l->jenis_aktivitas ?? '')) {
                                                'INSERT' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/60',
                                                'UPDATE' => 'bg-amber-50 text-amber-700 border border-amber-200/60',
                                                'DELETE' => 'bg-rose-50 text-rose-700 border border-rose-200/60',
                                                default => 'bg-slate-100 text-slate-700 border border-slate-200/60',
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold {{ $actionBadgeClass }}">
                                            {{ $l->jenis_aktivitas ?? 'LOG' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-800 font-medium line-clamp-1">
                                        {{ $l->aktivitas }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center">
                                        <div class="max-w-xs mx-auto text-center space-y-3">
                                            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                                <x-icon name="clock" class="w-6 h-6" />
                                            </div>
                                            <div>
                                                <p class="text-sm font-bold text-slate-800">Belum Ada Log Aktivitas</p>
                                                <p class="text-xs text-slate-500 mt-0.5">Audit trail aktivitas sistem akan dicatat di sini</p>
                                            </div>
                                            <div class="pt-2">
                                                <x-button variant="accent" :href="route('log-aktivitas.index')" class="px-4 py-2 text-xs">
                                                    <x-icon name="clock" class="w-3.5 h-3.5 mr-1.5" /> Lihat Log
                                                </x-button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </x-card>
    </div>
@endsection
