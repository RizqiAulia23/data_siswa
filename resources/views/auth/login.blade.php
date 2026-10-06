<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Data Siswa Portal Akademik</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-slate-900 min-h-screen flex flex-col items-center justify-center p-4 antialiased font-sans text-slate-900 selection:bg-blue-600 selection:text-white">
    <!-- Ambient Background Glow -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Login Card Container -->
    <div class="relative w-full max-w-md">
        <!-- Brand Header Badge -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white shadow-lg mb-4 ring-4 ring-white/10">
                <x-icon name="academic" class="w-7 h-7" />
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white">Portal Akademik</h1>
            <p class="text-xs text-slate-400 mt-1">Sistem Manajemen & Basis Data Siswa Terpadu</p>
        </div>

        <!-- Card Form -->
        <div class="glass-card-strong rounded-2xl shadow-xl border border-white/40 p-6 sm:p-8">
            <div class="mb-6 pb-4 border-b border-slate-100">
                <h2 class="text-lg font-bold text-slate-900">Masuk ke Akun</h2>
                <p class="text-xs text-slate-500 mt-0.5">Silakan masukkan kredensial akun Anda</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-xs shadow-xs" role="alert">
                    <div class="flex items-center space-x-2 font-semibold mb-1 text-rose-950">
                        <x-icon name="alert-circle" class="w-4 h-4 text-rose-600 flex-shrink-0" />
                        <span>Autentikasi Gagal</span>
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 pl-6 text-rose-800">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                        Alamat Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="admin@example.com"
                        class="w-full text-sm bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-[border-color,box-shadow] duration-150"
                    >
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold uppercase tracking-wider text-slate-700 mb-1.5">
                        Kata Sandi
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full text-sm bg-white border border-slate-300 rounded-lg px-3.5 py-2.5 text-slate-900 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-2 focus:ring-blue-500/20 transition-[border-color,box-shadow] duration-150"
                    >
                </div>

                <div class="pt-2">
                    <x-button
                        type="submit"
                        variant="primary"
                        class="w-full py-2.5 px-4 font-semibold shadow-md hover:shadow-lg space-x-2"
                    >
                        <span>Masuk ke Sistem</span>
                        <x-icon name="check" class="w-4 h-4" />
                    </x-button>
                </div>
            </form>
        </div>

        <!-- Footer Meta -->
        <div class="mt-8 text-center text-xs text-slate-500 space-y-1">
            <p>&copy; {{ date('Y') }} Sistem Data Siswa &bull; Portal Akademik</p>
            <p class="text-[11px] text-slate-400">PostgreSQL Verified &bull; Versi 1.0.0</p>
        </div>
    </div>
</body>
</html>
