<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Mapel;
use App\Models\Mengajar;
use App\Models\Nilai;
use App\Models\PendaftaranKelas;
use App\Models\Siswa;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalSiswa = Siswa::count();
        $totalGuru = Guru::count();
        $totalKelas = Kelas::count();
        $totalMapel = Mapel::count();
        $totalPendaftaranKelas = PendaftaranKelas::count();
        $totalMengajar = Mengajar::count();
        $totalNilai = Nilai::count();
        $totalLogAktivitas = LogAktivitas::count();

        $recentSiswa = Siswa::orderBy('nis', 'desc')->take(5)->get();
        $recentLog = LogAktivitas::orderBy('waktu', 'desc')->orderBy('id_log', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'totalPendaftaranKelas',
            'totalMengajar',
            'totalNilai',
            'totalLogAktivitas',
            'recentSiswa',
            'recentLog'
        ));
    }
}
