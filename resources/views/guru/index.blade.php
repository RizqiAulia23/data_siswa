@extends('layouts.app')

@section('title', 'Data Guru')

@section('content')
    <!-- Page Header -->
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center space-x-2.5">
                <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Daftar Guru</h1>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-700 border border-slate-200">
                    {{ $guru->total() }} Pengajar
                </span>
            </div>
            <p class="text-sm text-slate-500 mt-1">Manajemen data tenaga pengajar dan staf akademik</p>
        </div>
        <x-button variant="accent" :href="route('guru.create')" class="px-4 py-2.5 text-sm self-start sm:self-auto shadow-sm">
            <x-icon name="user-plus" class="w-4 h-4 mr-2" /> Tambah Guru Baru
        </x-button>
    </div>

    <!-- Table Card -->
    <x-card class="overflow-hidden">
        <x-table>
            <thead class="bg-slate-50/80 border-b border-slate-200/80">
                <tr>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">NIP</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Nama Guru</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Gender</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">No. HP</th>
                    <th scope="col" class="px-6 py-3.5 text-left font-bold text-[11px] uppercase tracking-wider text-slate-600">Status</th>
                    <th scope="col" class="px-6 py-3.5 text-right font-bold text-[11px] uppercase tracking-wider text-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($guru as $item)
                    <tr class="hover:bg-slate-50/70 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="font-mono text-xs font-semibold text-slate-800 bg-slate-100 px-2.5 py-1 rounded-md border border-slate-200/60">
                                {{ $item->nip ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900 text-sm">{{ $item->nama ?? '-' }}</div>
                            <div class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">{{ $item->alamat ?? 'Belum ada alamat' }}</div>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-700 whitespace-nowrap">
                            {{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : ($item->jenis_kelamin === 'P' ? 'Perempuan' : '-') }}
                        </td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-600 whitespace-nowrap">
                            {{ $item->nomor_hp ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $item->aktif ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/70' : 'bg-slate-100 text-slate-600 border border-slate-200/70' }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $item->aktif ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $item->aktif ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs">
                            <div class="flex items-center justify-end space-x-1.5">
                                <x-button variant="secondary" :href="route('guru.show', $item)" class="px-2.5 py-1.5 text-xs" aria-label="Detail guru {{ $item->nama }}">
                                    <x-icon name="eye" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Detail
                                </x-button>
                                <x-button variant="secondary" :href="route('guru.edit', $item)" class="px-2.5 py-1.5 text-xs" aria-label="Edit guru {{ $item->nama }}">
                                    <x-icon name="edit" class="w-3.5 h-3.5 mr-1 text-blue-600" /> Edit
                                </x-button>
                                <form action="{{ route('guru.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data guru {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button variant="danger" type="submit" class="px-2.5 py-1.5 text-xs" aria-label="Hapus guru {{ $item->nama }}">
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
                                    <x-icon name="user-plus" class="w-6 h-6" />
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">Belum Ada Data Guru</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Guru pengajar yang ditambahkan akan muncul pada tabel ini.</p>
                                </div>
                                <div class="pt-2">
                                    <x-button variant="accent" :href="route('guru.create')" class="px-4 py-2 text-xs">
                                        <x-icon name="user-plus" class="w-3.5 h-3.5 mr-1.5" /> Tambah Guru Pertama
                                    </x-button>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-table>

        @if ($guru->hasPages())
            <div class="px-6 py-4 border-t border-slate-200/80 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>
                    Menampilkan <strong class="text-slate-800">{{ $guru->firstItem() }}</strong> - <strong class="text-slate-800">{{ $guru->lastItem() }}</strong> dari <strong class="text-slate-800">{{ $guru->total() }}</strong> guru
                </p>
                <div>
                    {{ $guru->links() }}
                </div>
            </div>
        @endif
    </x-card>
@endsection
