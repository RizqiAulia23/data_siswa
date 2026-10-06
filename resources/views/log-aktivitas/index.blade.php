@extends('layouts.app')

@section('title', 'Log Aktivitas')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Log Aktivitas</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $logs->total() }} Catatan
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Riwayat audit trail aktivitas sistem akademik (Read-Only)</p>
        </div>
    </div>

    <!-- Table Card -->
    <x-card class="overflow-hidden">
        <x-table>
            <thead class="bg-slate-50/80 border-b border-slate-200/80">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">ID</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Aktivitas</th>
                    <th scope="col" class="px-6 py-3.5 text-center font-bold text-[11px] uppercase tracking-wider text-slate-600">Tipe</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Waktu</th>
                    <th scope="col" class="px-6 py-3.5 text-right font-bold text-[11px] uppercase tracking-wider text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($logs as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-xs font-semibold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200/60">
                                #{{ $item->id_log }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900 text-sm max-w-sm">
                            {{ $item->aktivitas ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            @php
                                $typeClass = match (strtoupper($item->jenis_aktivitas ?? '')) {
                                    'INSERT' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/70',
                                    'UPDATE' => 'bg-amber-50 text-amber-700 border border-amber-200/70',
                                    'DELETE' => 'bg-rose-50 text-rose-700 border border-rose-200/70',
                                    default => 'bg-slate-100 text-slate-700 border border-slate-200/70',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase border {{ $typeClass }}">
                                {{ $item->jenis_aktivitas ?? 'LOG' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs font-mono text-slate-600">
                            {{ $item->waktu ? $item->waktu->format('d/m/Y H:i:s') : '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                            <x-button variant="secondary" :href="route('log-aktivitas.show', $item)" class="px-2.5 py-1.5 text-xs" aria-label="Detail log #{{ $item->id_log }}">
                                <x-icon name="eye" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Detail
                            </x-button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="max-w-xs mx-auto text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                    <x-icon name="clock" class="w-6 h-6" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Belum Ada Catatan Log</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Aktivitas sistem yang terjadi akan dicatat di sini.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>

        @if ($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>
                    Menampilkan <strong class="text-slate-800">{{ $logs->firstItem() }}</strong> - <strong class="text-slate-800">{{ $logs->lastItem() }}</strong> dari <strong class="text-slate-800">{{ $logs->total() }}</strong> aktivitas
                </p>
                <div>
                    {{ $logs->links() }}
                </div>
            </div>
        @endif
    </x-card>
@endsection
