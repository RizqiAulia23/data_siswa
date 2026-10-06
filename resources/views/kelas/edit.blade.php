@extends('layouts.app')

@section('title', 'Edit Data Kelas')

@section('content')
    <nav aria-label="Breadcrumb" class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-slate-500">
            <li>
                <a href="{{ route('kelas.index') }}" class="hover:text-slate-900 transition font-medium">Daftar Kelas</a>
            </li>
            <li aria-hidden="true">&bull;</li>
            <li aria-current="page" class="font-semibold text-slate-900">Edit Kelas</li>
        </ol>
    </nav>

    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">Edit Data Kelas</h1>
        <p class="text-sm text-slate-500 mt-1">Perbarui nama kelas: <span class="font-mono font-medium text-slate-900">{{ $kelas->nama_kelas ?? '-' }}</span></p>
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
        <form action="{{ route('kelas.update', $kelas) }}" method="POST" class="p-6 md:p-8 space-y-6">
            @csrf
            @method('PUT')

            <x-input
                name="nama_kelas"
                id="nama_kelas"
                label="Nama Kelas"
                maxlength="20"
                :value="old('nama_kelas', $kelas->nama_kelas)"
            />

            <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                <x-button variant="secondary" :href="route('kelas.index')" class="py-2.5 px-6">
                    <x-icon name="arrow-left" class="w-4 h-4 mr-2" /> Batal
                </x-button>
                <x-button variant="primary" type="submit" class="py-2.5 px-6">
                    <x-icon name="check" class="w-4 h-4 mr-2" /> Perbarui Kelas
                </x-button>
            </div>
        </form>
    </x-card>
@endsection
