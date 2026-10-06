@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Daftar Rombongan Belajar (Kelas)</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $kelas->total() }} Kelas
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Struktur pembagian kelas dan ruang belajar siswa aktif</p>
        </div>
        <x-button variant="accent" :href="route('kelas.create')" class="px-4 py-2.5 text-sm self-start sm:self-auto shadow-sm">
            <x-icon name="plus" class="w-4 h-4 mr-2" /> Tambah Kelas Baru
        </x-button>
    </div>

    <!-- Table Card -->
    <x-card class="overflow-hidden">
        <x-table>
            <thead class="bg-slate-50/80 border-b border-slate-200/80">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">ID Kelas</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Nama Kelas</th>
                    <th scope="col" class="px-6 py-3.5 text-right font-bold text-[11px] uppercase tracking-wider text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($kelas as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-xs font-semibold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200/60">
                                #{{ $item->id_kelas }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-lg bg-amber-50 border border-amber-200/70 text-amber-700 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr($item->nama_kelas ?? 'K', 0, 2)) }}
                                </div>
                                <span>{{ $item->nama_kelas ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                            <div class="flex items-center justify-end space-x-1.5">
                                <x-button variant="secondary" :href="route('kelas.show', $item)" class="px-2.5 py-1.5 text-xs" aria-label="Detail kelas {{ $item->nama_kelas }}">
                                    <x-icon name="eye" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Detail
                                </x-button>
                                <x-button variant="secondary" :href="route('kelas.edit', $item)" class="px-2.5 py-1.5 text-xs" aria-label="Edit kelas {{ $item->nama_kelas }}">
                                    <x-icon name="edit" class="w-3.5 h-3.5 mr-1 text-blue-600" /> Edit
                                </x-button>
                                <form action="{{ route('kelas.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kelas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="danger" type="submit" class="px-2.5 py-1.5 text-xs" aria-label="Hapus kelas {{ $item->nama_kelas }}">
                                        <x-icon name="trash" class="w-3.5 h-3.5" />
                                    </x-button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <div class="max-w-xs mx-auto text-center space-y-3">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto">
                                    <x-icon name="academic" class="w-6 h-6" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Belum Ada Data Kelas</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Daftarkan ruang dan rombongan belajar pertama untuk memulai.</p>
                                </div>
                                <div class="pt-2">
                                    <x-button variant="accent" :href="route('kelas.create')" class="px-4 py-2 text-xs">
                                        <x-icon name="plus" class="w-3.5 h-3.5 mr-1.5" /> Tambah Kelas Pertama
                                    </x-button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>

        @if ($kelas->hasPages())
            <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>
                    Menampilkan <strong class="text-slate-800">{{ $kelas->firstItem() }}</strong> - <strong class="text-slate-800">{{ $kelas->lastItem() }}</strong> dari <strong class="text-slate-800">{{ $kelas->total() }}</strong> kelas
                </p>
                <div>
                    {{ $kelas->links() }}
                </div>
            </div>
        @endif
    </x-card>
@endsection
