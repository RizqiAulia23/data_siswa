<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_dashboard_and_is_redirected_to_login(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
        $response->assertViewHasAll([
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',
            'totalPendaftaranKelas',
            'totalMengajar',
            'totalNilai',
            'totalLogAktivitas',
            'recentSiswa',
            'recentLog',
        ]);
        $response->assertSee('Dashboard');
        $response->assertSee('Total Siswa');
        $response->assertSee('Total Guru');
        $response->assertSee('Total Kelas');
        $response->assertSee('Mata Pelajaran');
    }

    public function test_dashboard_displays_counts_and_recent_data_correctly(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        Siswa::create([
            'nis' => '1001',
            'nama' => 'Budi Santoso',
            'jenis_kelamin' => 'L',
        ]);
        Siswa::create([
            'nis' => '1002',
            'nama' => 'Siti Aminah',
            'jenis_kelamin' => 'P',
        ]);

        Guru::create([
            'nip' => '1980010101',
            'nama' => 'Pak Guru',
            'aktif' => true,
        ]);

        Kelas::create([
            'id_kelas' => 'X-RPL-1',
            'nama_kelas' => 'X RPL 1',
            'tingkat' => 10,
        ]);

        LogAktivitas::create([
            'aktivitas' => 'Data siswa ditambahkan: Budi Santoso',
            'waktu' => now(),
            'jenis_aktivitas' => 'INSERT',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Budi Santoso');
        $response->assertSee('Siti Aminah');
        $response->assertSee('Data siswa ditambahkan: Budi Santoso');
    }

    public function test_login_redirects_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }
}
