<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Mapel;
use App\Models\Mengajar;
use App\Models\PendaftaranKelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityRemediationTest extends TestCase
{
    use RefreshDatabase;

    // =========================================================================
    // 1. AUTHENTICATION TESTS
    // =========================================================================

    public function test_guest_cannot_access_protected_routes(): void
    {
        $routes = [
            route('dashboard'),
            route('siswa.index'),
            route('guru.index'),
            route('kelas.index'),
            route('mapel.index'),
            route('pendaftaran-kelas.index'),
            route('mengajar.index'),
            route('nilai.index'),
            route('log-aktivitas.index'),
        ];

        foreach ($routes as $url) {
            $response = $this->get($url);
            $response->assertRedirect(route('login'));
        }
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_cannot_login_with_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => 'admin@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_logout(): void
    {
        $this->actingAsAdmin();

        $response = $this->post(route('logout'));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    // =========================================================================
    // 2. AUTHORIZATION & IDOR TESTS
    // =========================================================================

    public function test_unauthorized_user_cannot_create_or_mutate_resources(): void
    {
        $this->actingAsSiswa();

        // Create siswa attempt
        $responseSiswa = $this->post(route('siswa.store'), [
            'nis' => '99999',
            'nama' => 'Hacker Siswa',
        ]);
        $responseSiswa->assertStatus(403);

        // Create guru attempt
        $responseGuru = $this->post(route('guru.store'), [
            'nama' => 'Hacker Guru',
        ]);
        $responseGuru->assertStatus(403);
    }

    public function test_idor_update_and_delete_blocked_for_unauthorized_role(): void
    {
        $siswa = Siswa::create(['nis' => '11111', 'nama' => 'Target Siswa']);
        $guru = Guru::create(['nama' => 'Target Guru']);

        $this->actingAsSiswa();

        // IDOR update attempt
        $updateResp = $this->put(route('siswa.update', $siswa), [
            'nis' => '11111',
            'nama' => 'Malicious Edit',
        ]);
        $updateResp->assertStatus(403);

        // IDOR delete attempt
        $deleteResp = $this->delete(route('guru.destroy', $guru));
        $deleteResp->assertStatus(403);
    }

    public function test_log_aktivitas_cannot_be_created_updated_or_deleted_by_anyone(): void
    {
        $this->actingAsAdmin();

        $log = LogAktivitas::create([
            'aktivitas' => 'Initial Log',
            'waktu' => now(),
            'jenis_aktivitas' => 'TEST',
        ]);

        // Route level blocks mutate methods (only index & show exist)
        $this->assertFalse(\Route::has('log-aktivitas.store'));
        $this->assertFalse(\Route::has('log-aktivitas.update'));
        $this->assertFalse(\Route::has('log-aktivitas.destroy'));
    }

    // =========================================================================
    // 3. SENSITIVE DATA — SALARY TESTS
    // =========================================================================

    public function test_admin_can_view_guru_salary(): void
    {
        $this->actingAsAdmin();

        $guru = Guru::create([
            'nama' => 'Guru Sejahtera',
            'gaji' => 8500000.00,
        ]);

        $response = $this->get(route('guru.show', $guru));
        $response->assertStatus(200);
        $response->assertSee('8.500.000,00');
    }

    public function test_non_admin_cannot_view_guru_salary(): void
    {
        $this->actingAsGuru();

        $guru = Guru::create([
            'nama' => 'Guru Lain',
            'gaji' => 8500000.00,
        ]);

        $response = $this->get(route('guru.show', $guru));
        $response->assertStatus(200);
        $response->assertDontSee('8.500.000,00');
    }

    // =========================================================================
    // 4. VALIDATION HARDENING TESTS
    // =========================================================================

    public function test_jam_masuk_validation(): void
    {
        $this->actingAsAdmin();

        // Valid times
        $valid1 = $this->post(route('guru.store'), ['nama' => 'Guru 1', 'jam_masuk' => '07:30:00']);
        $valid1->assertRedirect(route('guru.index'));

        $valid2 = $this->post(route('guru.store'), ['nama' => 'Guru 2', 'jam_masuk' => '08:00']);
        $valid2->assertRedirect(route('guru.index'));

        // Invalid times
        $invalid1 = $this->post(route('guru.store'), ['nama' => 'Guru 3', 'jam_masuk' => '99:99:99']);
        $invalid1->assertSessionHasErrors('jam_masuk');

        $invalid2 = $this->post(route('guru.store'), ['nama' => 'Guru 4', 'jam_masuk' => 'invalid-time']);
        $invalid2->assertSessionHasErrors('jam_masuk');
    }

    public function test_nilai_kktp_range_validation(): void
    {
        $this->actingAsAdmin();

        // Valid 0 and 100
        $valid0 = $this->post(route('mapel.store'), [
            'kode_mapel' => 'MP-0',
            'nama_mapel' => 'Mapel Nol',
            'jumlah_jam' => 2,
            'nilai_kktp' => 0,
        ]);
        $valid0->assertRedirect(route('mapel.index'));

        $valid100 = $this->post(route('mapel.store'), [
            'kode_mapel' => 'MP-100',
            'nama_mapel' => 'Mapel Seratus',
            'jumlah_jam' => 2,
            'nilai_kktp' => 100,
        ]);
        $valid100->assertRedirect(route('mapel.index'));

        // Invalid < 0 or > 100
        $neg = $this->post(route('mapel.store'), [
            'kode_mapel' => 'MP-NEG',
            'nama_mapel' => 'Mapel Negatif',
            'jumlah_jam' => 2,
            'nilai_kktp' => -5,
        ]);
        $neg->assertSessionHasErrors('nilai_kktp');

        $over = $this->post(route('mapel.store'), [
            'kode_mapel' => 'MP-OVER',
            'nama_mapel' => 'Mapel Lebih',
            'jumlah_jam' => 2,
            'nilai_kktp' => 105,
        ]);
        $over->assertSessionHasErrors('nilai_kktp');
    }

    public function test_tahun_and_tahun_ajaran_format_validation(): void
    {
        $this->actingAsAdmin();

        $siswa = Siswa::create(['nis' => '30001', 'nama' => 'Siswa Tahun']);
        $kelas = Kelas::create(['nama_kelas' => 'X-Tahun']);
        $guru = Guru::create(['nama' => 'Guru Tahun']);
        $mapel = Mapel::create(['kode_mapel' => 'MP-TH', 'nama_mapel' => 'Mapel Tahun', 'jumlah_jam' => 2]);

        // PendaftaranKelas tahun valid: YYYY
        $respPKValid = $this->post(route('pendaftaran-kelas.store'), [
            'nis' => $siswa->nis,
            'id_kelas' => $kelas->id_kelas,
            'tahun' => '2026',
        ]);
        $respPKValid->assertRedirect(route('pendaftaran-kelas.index'));

        // PendaftaranKelas tahun invalid
        $respPKInvalid = $this->post(route('pendaftaran-kelas.store'), [
            'nis' => $siswa->nis,
            'id_kelas' => $kelas->id_kelas,
            'tahun' => '26',
        ]);
        $respPKInvalid->assertSessionHasErrors('tahun');

        // Mengajar tahun_ajaran valid: YYYY or YYYY/YYYY
        $respMgjValid1 = $this->post(route('mengajar.store'), [
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas->id_kelas,
            'tahun_ajaran' => '2025/2026',
        ]);
        $respMgjValid1->assertRedirect(route('mengajar.index'));

        // Mengajar tahun_ajaran invalid
        $respMgjInvalid = $this->post(route('mengajar.store'), [
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas->id_kelas,
            'tahun_ajaran' => 'semester-ganjil',
        ]);
        $respMgjInvalid->assertSessionHasErrors('tahun_ajaran');
    }

    // =========================================================================
    // 5. DELETE SAFETY & AUDIT LOGGING TESTS
    // =========================================================================

    public function test_delete_safety_with_transaction(): void
    {
        $this->actingAsAdmin();

        $siswa = Siswa::create(['nis' => '40001', 'nama' => 'Siswa Dependent']);
        $kelas = Kelas::create(['nama_kelas' => 'X-Safe']);
        $mapel = Mapel::create(['kode_mapel' => 'MP-SAFE', 'nama_mapel' => 'Mapel Safe', 'jumlah_jam' => 2]);

        PendaftaranKelas::create(['nis' => $siswa->nis, 'id_kelas' => $kelas->id_kelas]);

        // Attempt delete siswa with dependent pendaftaran_kelas
        $resp = $this->delete(route('siswa.destroy', $siswa));
        $resp->assertRedirect(route('siswa.index'));
        $resp->assertSessionHas('error');
        $this->assertDatabaseHas('siswa', ['nis' => '40001']);
    }

    public function test_crud_actions_produce_activity_logs(): void
    {
        $this->actingAsAdmin();

        $initialLogCount = LogAktivitas::count();

        // Create Siswa
        $this->post(route('siswa.store'), [
            'nis' => '50001',
            'nama' => 'Siswa Audit Log',
        ]);

        $this->assertDatabaseHas('log_aktivitas', [
            'aktivitas' => 'Data siswa ditambahkan: Siswa Audit Log',
            'jenis_aktivitas' => 'INSERT',
        ]);

        $siswa = Siswa::where('nis', '50001')->first();

        // Update Siswa
        $this->put(route('siswa.update', $siswa), [
            'nis' => '50001',
            'nama' => 'Siswa Audit Log Renamed',
        ]);

        $this->assertDatabaseHas('log_aktivitas', [
            'aktivitas' => 'Data siswa diperbarui: Siswa Audit Log Renamed',
            'jenis_aktivitas' => 'UPDATE',
        ]);

        // Delete Siswa
        $this->delete(route('siswa.destroy', $siswa));

        $this->assertDatabaseHas('log_aktivitas', [
            'aktivitas' => 'Data siswa dihapus: Siswa Audit Log Renamed',
            'jenis_aktivitas' => 'DELETE',
        ]);

        $this->assertEquals($initialLogCount + 3, LogAktivitas::count());
    }
}
