@extends('layouts.app')

@section('title', 'Tambah Data Nilai')

@section('content')
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('nilai.index') }}" class="hover:text-slate-900 transition font-medium">Data Nilai</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">Tambah Baru</li>
        </ol>
    </nav>

    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Tambah Data Nilai</h1>
        <p class="text-sm text-slate-500 mt-1">Lengkapi data untuk menambahkan nilai siswa ke dalam sistem akademik.</p>
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
        <form action="{{ route('nilai.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <!-- Siswa -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="nis">
                        Siswa *
                    </label>
                    <x-select name="nis" id="nis" required placeholder="-- Pilih Siswa --">
                        @foreach ($siswa as $s)
                            <option value="{{ $s->nis }}" {{ old('nis') == $s->nis ? 'selected' : '' }}>
                                {{ $s->nama }} (NIS: {{ $s->nis }})
                            </option>
                        @endforeach
                    </x-select>
                    @error('nis')
                        <p id="nis-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mapel -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="id_mapel">
                        Mata Pelajaran *
                    </label>
                    <x-select name="id_mapel" id="id_mapel" required placeholder="-- Pilih Mata Pelajaran --">
                        @foreach ($mapel as $m)
                            <option value="{{ $m->id_mapel }}" {{ old('id_mapel') == $m->id_mapel ? 'selected' : '' }}>
                                {{ $m->nama_mapel }} ({{ $m->kode_mapel }})
                            </option>
                        @endforeach
                    </x-select>
                    @error('id_mapel')
                        <p id="id_mapel-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <x-input
                    type="number"
                    name="semester"
                    id="semester"
                    label="Semester"
                    :value="old('semester')"
                />

                <x-input
                    type="number"
                    step="0.01"
                    min="0"
                    max="100"
                    name="nilai"
                    id="nilai"
                    label="Nilai (Skala 0 - 100)"
                    :value="old('nilai')"
                />
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                <x-button variant="secondary" :href="route('nilai.index')" class="py-2.5 px-6">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" /> Batal
                </x-button>
                <x-button variant="primary" type="submit" class="py-2.5 px-6">
                    <x-icon name="check" class="w-4 h-4 mr-2" /> Simpan Nilai
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
