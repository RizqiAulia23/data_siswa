@extends('layouts.app')

@section('title', 'Detail Log Aktivitas')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('log-aktivitas.index') }}" class="hover:text-slate-900 transition font-medium">Log Aktivitas</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">
                Log #{{ $log->id_log }}
            </li>
        </ol>
    </nav>

    <!-- Header Actions -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Detail Log Aktivitas</h1>
            <p class="text-sm text-slate-500 mt-1">Detail jejak aktivitas dan modifikasi data sistem akademik</p>
        </div>
        <div class="flex items-center space-x-2 self-start sm:self-auto">
            <x-button variant="secondary" :href="route('log-aktivitas.index')" class="py-2 px-3.5 text-xs">
                <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Kembali
            </x-button>
        </div>
    </div>

    <!-- Main Detail Card -->
    <x-card class="overflow-hidden">
        <!-- Hero Identity Banner -->
        <div class="p-6 sm:p-8 bg-slate-900 text-white flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-slate-800 border border-slate-700 text-slate-300 flex items-center justify-center flex-shrink-0">
                    <x-icon name="clock" class="w-7 h-7" />
                </div>
                <div>
                    <div class="flex items-center space-x-2">
                        <h2 class="text-2xl font-bold tracking-tight text-white">Log Record #{{ $log->id_log }}</h2>
                        @php
                            $typeClass = match (strtoupper($log->jenis_aktivitas ?? '')) {
                                'INSERT' => 'bg-emerald-500/20 text-emerald-300 border-emerald-500/40',
                                'UPDATE' => 'bg-amber-500/20 text-amber-300 border-amber-500/40',
                                'DELETE' => 'bg-rose-500/20 text-rose-300 border-rose-500/40',
                                default => 'bg-slate-700 text-slate-300 border-slate-600',
                            };
                        @endphp
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider border {{ $typeClass }}">
                            {{ $log->jenis_aktivitas ?? 'AUDIT' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 mt-1 font-mono">
                        {{ $log->waktu ? $log->waktu->format('l, d F Y - H:i:s T') : '-' }}
                    </p>
                </div>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-800 text-slate-300 border border-slate-700/80 self-start sm:self-auto">
                Immutable Record (Read-Only)
            </span>
        </div>

        <!-- Detail Data Grid -->
        <div class="p-6 sm:p-8 space-y-6">
            <h3 class="text-xs font-bold text-slate-600 uppercase tracking-wider">Parameter Event</h3>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-id">Log Identifier</label>
                    <p id="detail-id" class="text-base font-mono font-bold text-slate-900">#{{ $log->id_log }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-action">Jenis Aksi</label>
                    <p id="detail-action" class="text-base font-bold text-slate-900 uppercase">{{ $log->jenis_aktivitas ?? '-' }}</p>
                </div>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/80">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-1" for="detail-time">Timestamp</label>
                    <p id="detail-time" class="text-sm font-mono font-semibold text-slate-800">{{ $log->waktu ? $log->waktu->format('Y-m-d H:i:s') : '-' }}</p>
                </div>
            </div>

            <div class="p-5 rounded-xl bg-slate-50 border border-slate-200/80">
                <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-600 mb-2" for="detail-desc">Deskripsi Aktivitas</label>
                <div id="detail-desc" class="p-4 bg-white rounded-lg border border-slate-200 text-sm font-mono text-slate-800 leading-relaxed whitespace-pre-wrap">
{{ $log->aktivitas ?? 'Tidak ada payload aktivitas tambahan.' }}
                </div>
            </div>
        </div>
    </x-card>
@endsection
