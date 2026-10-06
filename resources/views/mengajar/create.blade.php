@extends('layouts.app')

@section('title', 'Tambah Penugasan Mengajar')

@section('content')
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('mengajar.index') }}" class="hover:text-slate-900 transition font-medium">Penugasan Mengajar</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">Tambah Baru</li>
        </ol>
    </nav>

    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Tambah Penugasan Mengajar</h1>
        <p class="text-sm text-slate-500 mt-1">Lengkapi data untuk menugaskan guru ke mata pelajaran dan kelas.</p>
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
        <form action="{{ route('mengajar.store') }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <!-- Dropdown Guru -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="id_guru">
                        Guru Pengajar *
                    </label>
                    <x-select name="id_guru" id="id_guru" required placeholder="-- Pilih Guru --">
                        @foreach ($guru as $g)
                            <option value="{{ $g->id_guru }}" {{ old('id_guru') == $g->id_guru ? 'selected' : '' }}>
                                {{ $g->nama }} (NIP: {{ $g->nip ?? '-' }})
                            </option>
                        @endforeach
                    </x-select>
                    @error('id_guru')
                        <p id="id_guru-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dropdown Mapel -->
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

                <!-- Dropdown Kelas -->
                <div>
                    <label class="block text-xs font-semibold uppercase tracking-wider mb-2 text-slate-700" for="id_kelas">
                        Kelas *
                    </label>
                    <x-select name="id_kelas" id="id_kelas" required placeholder="-- Pilih Kelas --">
                        @foreach ($kelas as $k)
                            <option value="{{ $k->id_kelas }}" {{ old('id_kelas') == $k->id_kelas ? 'selected' : '' }}>
                                {{ $k->nama_kelas }}
                            </option>
                        @endforeach
                    </x-select>
                    @error('id_kelas')
                        <p id="id_kelas-error" class="mt-1.5 text-xs text-rose-600" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Ajaran -->
                <x-input
                    name="tahun_ajaran"
                    id="tahun_ajaran"
                    label="Tahun Ajaran (Contoh: 2024/2025)"
                    maxlength="9"
                    :value="old('tahun_ajaran')"
                />
            </div>

            <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                <x-button variant="secondary" :href="route('mengajar.index')" class="py-2.5 px-6">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" /> Batal
                </x-button>
                <x-button variant="primary" type="submit" class="py-2.5 px-6">
                    <x-icon name="check" class="w-4 h-4 mr-2" /> Simpan Penugasan
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
