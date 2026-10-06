@extends('layouts.app')

@section('title', 'Data Nilai')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Daftar Nilai Siswa</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $nilai->total() }} Catatan
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Rekapitulasi hasil belajar siswa berdasarkan mata pelajaran dan semester</p>
        </div>
        <x-button variant="accent" :href="route('nilai.create')" class="px-4 py-2.5 text-sm self-start sm:self-auto shadow-sm">
            <x-icon name="plus" class="w-4 h-4 mr-2" /> Tambah Nilai Baru
        </x-button>
    </div>

    <!-- Table Card -->
    <x-card class="overflow-hidden">
        <x-table>
            <thead class="bg-slate-50/80 border-b border-slate-200/80">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">ID</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Nama Siswa</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Mata Pelajaran</th>
                    <th scope="col" class="px-6 py-3.5 text-center font-bold text-[11px] uppercase tracking-wider text-slate-600">Semester</th>
                    <th scope="col" class="px-6 py-3.5 text-right font-bold text-[11px] uppercase tracking-wider text-slate-600">Nilai</th>
                    <th scope="col" class="px-6 py-3.5 text-right font-bold text-[11px] uppercase tracking-wider text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($nilai as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-xs font-semibold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200/60">
                                #{{ $item->id_nilai }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-semibold text-slate-900 text-sm">
                            {{ $item->siswa?->nama ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700">
                            {{ $item->mapel?->nama_mapel ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200/70">
                                S{{ $item->semester ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            @if (!empty($item->nilai))
                                <span class="inline-flex items-center justify-center min-w-[3.5rem] px-2.5 py-1 rounded-lg text-sm font-bold {{ $item->nilai >= 75 ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-rose-50 text-rose-700 border border-rose-200/70' }}">
                                    {{ $item->nilai }}
                                </span>
                            @else
                                <span class="text-slate-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                            <div class="flex items-center justify-end space-x-1.5">
                                <x-button variant="secondary" :href="route('nilai.show', $item)" class="px-2.5 py-1.5 text-xs" aria-label="Detail nilai {{ $item->siswa?->nama }}">
                                    <x-icon name="eye" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Detail
                                </x-button>
                                <x-button variant="secondary" :href="route('nilai.edit', $item)" class="px-2.5 py-1.5 text-xs" aria-label="Edit nilai {{ $item->siswa?->nama }}">
                                    <x-icon name="edit" class="w-3.5 h-3.5 mr-1 text-blue-600" /> Edit
                                </x-button>
                                <form action="{{ route('nilai.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus nilai siswa ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="danger" type="submit" class="px-2.5 py-1.5 text-xs" aria-label="Hapus nilai {{ $item->siswa?->nama }}">
                                        <x-icon name="trash" class="w-3.5 h-3.5" />
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="max-w-xs mx-auto text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                    <x-icon name="chart" class="w-6 h-6" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Belum Ada Data Nilai</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Nilai siswa yang diinput akan ditampilkan pada tabel ini.</p>
                                </div>
                                <div class="pt-2">
                                    <x-button variant="accent" :href="route('nilai.create')" class="px-4 py-2 text-xs">
                                        <x-icon name="plus" class="w-3.5 h-3.5 mr-1.5" /> Tambah Nilai Pertama
                                    </x-button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>

        @if ($nilai->hasPages())
            <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>
                    Menampilkan <strong class="text-slate-800">{{ $nilai->firstItem() }}</strong> - <strong class="text-slate-800">{{ $nilai->lastItem() }}</strong> dari <strong class="text-slate-800">{{ $nilai->total() }}</strong> nilai
                </p>
                <div>
                    {{ $nilai->links() }}
                </div>
            </div>
        @endif
    </x-card>
@endsection
