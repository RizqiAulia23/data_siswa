<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Data Siswa') - Portal Akademik</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <style>
        :root {
            --primary: #0f172a;
            --primaryLight: #1e293b;
            --accent: #2563eb;
            --accentHover: #1d4ed8;
            --canvas: #f8fafc;
        }
        body {
            background-color: var(--canvas);
        }
    </style>
</head>
<body class="text-slate-900 bg-slate-50 antialiased font-sans">
    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-3 focus:left-3 focus:z-50 focus:px-4 focus:py-2 focus:bg-slate-900 focus:text-white focus:rounded-lg focus:shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-xs font-semibold">
        Lewati ke konten utama
    </a>

    <div class="min-h-screen flex flex-col md:flex-row relative overflow-hidden bg-[#E8EDF5]">
        <!-- Global Vivid mesh blobs — liquid glass needs saturated background to refract -->
        <div aria-hidden="true" class="pointer-events-none fixed inset-0 overflow-hidden z-0">
            <div class="absolute -top-20 -left-20 h-[36rem] w-[36rem] rounded-full bg-[#93C5FD]/60 blur-[130px]"></div>
            <div class="absolute top-1/3 -left-32 h-[32rem] w-[32rem] rounded-full bg-[#C4B5FD]/55 blur-[120px]"></div>
            <div class="absolute -bottom-32 left-1/4 h-[30rem] w-[30rem] rounded-full bg-[#A7F3D0]/45 blur-[120px]"></div>
            <div class="absolute -top-20 right-0 h-[38rem] w-[38rem] rounded-full bg-[#FBC4E0]/45 blur-[130px]"></div>
            <div class="absolute bottom-10 right-10 h-[32rem] w-[32rem] rounded-full bg-[#93C5FD]/50 blur-[120px]"></div>
        </div>

        <!-- Sidebar Navigation (Light Liquid Glass) -->
        <aside class="relative z-10 md:w-64 sidebar-glass text-slate-800 flex-shrink-0 flex flex-col justify-between" aria-label="Navigasi Utama">
            <div>
                <!-- Brand Header -->
                <div class="p-5 border-b border-white/60 flex items-center space-x-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white flex items-center justify-center shadow-md flex-shrink-0">
                        <x-icon name="academic" class="w-5 h-5" />
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-base font-bold text-slate-900 tracking-tight leading-tight truncate">Data Siswa</h1>
                        <p class="text-[11px] font-semibold text-blue-600/80 uppercase tracking-wider">Portal Akademik</p>
                    </div>
                </div>

                <!-- Navigation Links Categorized -->
                <nav class="p-3 space-y-5" aria-label="Menu Utama">
                    <!-- Section: UTAMA -->
                    <div>
                        <p class="px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-500">Utama</p>
                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ Route::currentRouteName() === 'dashboard' ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="dashboard" class="w-4 h-4 flex-shrink-0 {{ Route::currentRouteName() === 'dashboard' ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Dashboard</span>
                            </a>
                        </div>
                    </div>

                    <!-- Section: AKADEMIK -->
                    <div>
                        <p class="px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-500">Data Master</p>
                        <div class="space-y-1">
                            <a href="{{ route('siswa.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'siswa.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="users" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'siswa.') ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Siswa</span>
                            </a>
                            <a href="{{ route('guru.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'guru.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="user-plus" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'guru.') ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Guru</span>
                            </a>
                            <a href="{{ route('kelas.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'kelas.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="academic" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'kelas.') ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Kelas</span>
                            </a>
                            <a href="{{ route('mapel.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'mapel.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="book" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'mapel.') ? 'text-blue-400' : 'text-slate-400' }}" />
                                <span>Mata Pelajaran</span>
                            </a>
                        </div>
                    </div>

                    <!-- Section: MANAJEMEN -->
                    <div>
                        <p class="px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-500">Pembelajaran</p>
                        <div class="space-y-1">
                            <a href="{{ route('pendaftaran-kelas.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'pendaftaran-kelas.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="check" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'pendaftaran-kelas.') ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Pendaftaran Kelas</span>
                            </a>
                            <a href="{{ route('mengajar.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'mengajar.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="academic" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'mengajar.') ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Penugasan Mengajar</span>
                            </a>
                            <a href="{{ route('nilai.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'nilai.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="chart" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'nilai.') ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Nilai Siswa</span>
                            </a>
                        </div>
                    </div>

                    <!-- Section: AUDIT -->
                    <div>
                        <p class="px-3 mb-1.5 text-[10px] font-bold uppercase tracking-wider text-slate-500">Sistem</p>
                        <div class="space-y-1">
                            <a href="{{ route('log-aktivitas.index') }}"
                               class="flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ str_starts_with(Route::currentRouteName() ?? '', 'log-aktivitas.') ? 'sidebar-nav-active' : 'sidebar-nav-link' }}">
                                <x-icon name="clock" class="w-4 h-4 flex-shrink-0 {{ str_starts_with(Route::currentRouteName() ?? '', 'log-aktivitas.') ? 'text-blue-600' : 'text-slate-500' }}" />
                                <span>Log Aktivitas</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>

            <!-- Sidebar Footer: Session Info -->
            <div class="p-4 border-t border-white/60 bg-white/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-bold text-xs flex-shrink-0 shadow-xs">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-slate-800 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <span class="inline-block text-[10px] font-bold text-emerald-600 tracking-wider uppercase">{{ ucfirst(Auth::user()->role ?? 'admin') }}</span>
                        </div>
                    </div>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" title="Keluar dari sistem" aria-label="Keluar dari sistem" class="p-1.5 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-white/60 transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500">
                                <x-icon name="arrow-left" class="w-4 h-4" />
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 relative overflow-hidden">
            <!-- Topbar Header -->
            <header class="relative z-10 bg-white/45 backdrop-blur-xl border-b border-white/50 sticky top-0 shadow-xs">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">
                    <!-- Left: Breadcrumb / Path Info -->
                    <div class="flex items-center space-x-2 text-xs text-slate-500">
                        <span class="font-medium text-slate-400">Portal Akademik</span>
                        <span>/</span>
                        <span class="font-semibold text-slate-800">
                            @yield('title', 'Dashboard')
                        </span>
                    </div>

                    <!-- Right: System Status & User Actions -->
                    <div class="flex items-center space-x-4">
                        <!-- Database Connection Status -->
                        <div class="hidden sm:inline-flex items-center space-x-1.5 px-2.5 py-1 rounded-full bg-emerald-50 border border-emerald-200/70 text-[11px] font-medium text-emerald-700">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>DB Aktif</span>
                        </div>

                        @auth
                            <div class="flex items-center space-x-3 pl-2 border-l border-slate-200">
                                <span class="text-xs text-slate-600 hidden md:inline">
                                    Halo, <strong class="text-slate-900">{{ Auth::user()->name }}</strong>
                                </span>
                                <form action="{{ route('logout') }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-slate-200 bg-white text-xs font-medium text-slate-600 hover:bg-slate-50 hover:text-rose-600 hover:border-rose-200 transition-all duration-150 shadow-xs focus:outline-none focus:ring-2 focus:ring-rose-500">
                                        <x-icon name="arrow-left" class="w-3.5 h-3.5 mr-1 text-slate-400" /> Keluar
                                    </button>
                                </form>
                            </div>
                        @endauth
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main id="main-content" class="relative z-10 flex-1 overflow-auto p-4 sm:p-6 lg:p-8">
                <div class="max-w-7xl mx-auto">
                    <!-- Flash Notifications -->
                    @if (session('success'))
                        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-start space-x-3 shadow-xs" role="status">
                            <div class="w-6 h-6 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <x-icon name="check" class="w-4 h-4" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-emerald-950">Berhasil</p>
                                <p class="text-xs text-emerald-800 mt-0.5">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 flex items-start space-x-3 shadow-xs" role="alert">
                            <div class="w-6 h-6 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <x-icon name="alert-circle" class="w-4 h-4" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-rose-950">Terjadi Kesalahan</p>
                                <p class="text-xs text-rose-800 mt-0.5">{{ session('error') }}</p>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
