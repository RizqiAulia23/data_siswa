@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('content')
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('mapel.index') }}" class="hover:text-slate-900 transition font-medium">Daftar Mapel</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li>
                <a href="{{ route('mapel.show', $mapel) }}" class="hover:text-slate-900 transition font-medium">{{ $mapel->nama_mapel }}</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">Edit</li>
        </ol>
    </nav>

    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Edit Data Mata Pelajaran</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui mata pelajaran: <span class="font-mono font-medium text-slate-900">{{ $mapel->nama_mapel }}</span></p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-5 rounded-xl border border-rose-200 bg-rose-50 text-rose-900 shadow-xs" role="alert" aria-labelledby="validation-errors-title">
            <div class="flex items-start space-x-3">
                <x-icon name="alert-circle" class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" />
                <div>
                    <p id="validation-errors-title" class="font-semibold text-sm mb-1">Periksa kembali data yang dimasukkan:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs text-rose-800 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <x-card class="overflow-hidden">
        <form action="{{ route('mapel.update', $mapel) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <x-input
                    name="kode_mapel"
                    id="kode_mapel"
                    label="Kode Mata Pelajaran"
                    maxlength="50"
                    :value="old('kode_mapel', $mapel->kode_mapel)"
                    required
                />
                <x-input
                    name="nama_mapel"
                    id="nama_mapel"
                    label="Nama Mata Pelajaran"
                    maxlength="100"
                    :value="old('nama_mapel', $mapel->nama_mapel)"
                    required
                />
                <x-input
                    name="kategori"
                    id="kategori"
                    label="Kategori"
                    maxlength="50"
                    :value="old('kategori', $mapel->kategori)"
                />
                <x-input
                    type="number"
                    name="jumlah_jam"
                    id="jumlah_jam"
                    label="Jumlah Jam"
                    :value="old('jumlah_jam', $mapel->jumlah_jam)"
                    required
                />
                <x-input
                    type="number"
                    name="nilai_kktp"
                    id="nilai_kktp"
                    label="Nilai KKTP"
                    :value="old('nilai_kktp', $mapel->nilai_kktp)"
                />
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="aktif">
                        Status Aktif
                    </label>
                    <x-select name="aktif" id="aktif">
                        <option value="1" {{ old('aktif', $mapel->aktif ? 1 : 0) == 1 ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ old('aktif', $mapel->aktif ? 1 : 0) == 0 ? 'selected' : '' }}>Non-Aktif</option>
                    </x-select>
                    @error('aktif')
                        <p id="aktif-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
                <x-input
                    type="number"
                    name="semester"
                    id="semester"
                    label="Semester"
                    :value="old('semester', $mapel->semester)"
                />
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="deskripsi">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="3"
                              class="w-full text-sm bg-white border rounded-lg px-4 py-2.5 text-slate-900 placeholder-slate-400 focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-[border-color,box-shadow] duration-150 @error('deskripsi') border-rose-500 focus:border-rose-500 focus:ring-rose-500/20 @else border-slate-300 hover:border-slate-400 @enderror"
                              @error('deskripsi') aria-invalid="true" aria-describedby="deskripsi-error" @enderror>{{ old('deskripsi', $mapel->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p id="deskripsi-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                <x-button variant="secondary" :href="route('mapel.index')" class="py-2.5 px-6">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" /> Batal
                </x-button>
                <x-button variant="primary" type="submit" class="py-2.5 px-6">
                    <x-icon name="check" class="w-4 h-4 mr-2" /> Perbarui Mapel
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
