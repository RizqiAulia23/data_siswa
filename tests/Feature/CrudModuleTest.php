<?php

namespace Tests\Feature;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Mapel;
use App\Models\Mengajar;
use App\Models\Nilai;
use App\Models\PendaftaranKelas;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CrudModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAsAdmin();
    }

    // ==========================================
    // 1. SISWA CRUD TESTS
    // ==========================================

    public function test_siswa_index_returns_ok(): void
    {
        $response = $this->get(route('siswa.index'));
        $response->assertStatus(200);
        $response->assertViewIs('siswa.index');
    }

    public function test_siswa_create_returns_ok(): void
    {
        $response = $this->get(route('siswa.create'));
        $response->assertStatus(200);
        $response->assertViewIs('siswa.create');
    }

    public function test_siswa_store_creates_record(): void
    {
        $data = [
            'nis' => '10001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Jl. Merdeka No. 1',
            'email' => 'budi@example.com',
            'nomor_hp' => '081234567890',
            'agama' => 'Islam',
            'jenis_kelamin' => 'L',
        ];

        $response = $this->post(route('siswa.store'), $data);
        $response->assertRedirect(route('siswa.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('siswa', ['nis' => '10001', 'nama' => 'Budi Santoso']);
    }

    public function test_siswa_show_returns_ok(): void
    {
        $siswa = Siswa::create(['nis' => '10002', 'nama' => 'Siti Rahma']);

        $response = $this->get(route('siswa.show', $siswa));
        $response->assertStatus(200);
        $response->assertViewIs('siswa.show');
        $response->assertSee('Siti Rahma');
    }

    public function test_siswa_edit_returns_ok(): void
    {
        $siswa = Siswa::create(['nis' => '10003', 'nama' => 'Agus Priyono']);

        $response = $this->get(route('siswa.edit', $siswa));
        $response->assertStatus(200);
        $response->assertViewIs('siswa.edit');
    }

    public function test_siswa_update_modifies_record(): void
    {
        $siswa = Siswa::create(['nis' => '10004', 'nama' => 'Dewi Lestari']);

        $response = $this->put(route('siswa.update', $siswa), [
            'nis' => '10004',
            'nama' => 'Dewi Sartika',
            'email' => 'dewi@example.com',
            'jenis_kelamin' => 'P',
        ]);

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('siswa', ['nis' => '10004', 'nama' => 'Dewi Sartika']);
    }

    public function test_siswa_destroy_deletes_record(): void
    {
        $siswa = Siswa::create(['nis' => '10005', 'nama' => 'Rudi Hartono']);

        $response = $this->delete(route('siswa.destroy', $siswa));
        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseMissing('siswa', ['nis' => '10005']);
    }

    // ==========================================
    // 2. GURU CRUD TESTS
    // ==========================================

    public function test_guru_index_returns_ok(): void
    {
        $response = $this->get(route('guru.index'));
        $response->assertStatus(200);
        $response->assertViewIs('guru.index');
    }

    public function test_guru_create_returns_ok(): void
    {
        $response = $this->get(route('guru.create'));
        $response->assertStatus(200);
        $response->assertViewIs('guru.create');
    }

    public function test_guru_store_creates_record(): void
    {
        $data = [
            'nip' => '198501012010011001',
            'nama' => 'Drs. Supriyanto, M.Pd.',
            'jenis_kelamin' => 'L',
            'gaji' => 4500000.00,
            'aktif' => true,
        ];

        $response = $this->post(route('guru.store'), $data);
        $response->assertRedirect(route('guru.index'));
        $this->assertDatabaseHas('guru', ['nip' => '198501012010011001', 'nama' => 'Drs. Supriyanto, M.Pd.']);
    }

    public function test_guru_show_returns_ok(): void
    {
        $guru = Guru::create(['nama' => 'Sri Wahyuni, S.Pd.', 'nip' => '199002022015022002']);

        $response = $this->get(route('guru.show', $guru));
        $response->assertStatus(200);
        $response->assertViewIs('guru.show');
        $response->assertSee('Sri Wahyuni, S.Pd.');
    }

    public function test_guru_edit_returns_ok(): void
    {
        $guru = Guru::create(['nama' => 'Bambang Sudibyo, M.Si.']);

        $response = $this->get(route('guru.edit', $guru));
        $response->assertStatus(200);
        $response->assertViewIs('guru.edit');
    }

    public function test_guru_update_modifies_record(): void
    {
        $guru = Guru::create(['nama' => 'Ahmad Fauzi', 'nip' => '198803032014031003']);

        $response = $this->put(route('guru.update', $guru), [
            'nama' => 'Dr. Ahmad Fauzi, M.Kom.',
            'nip' => '198803032014031003',
            'aktif' => true,
        ]);

        $response->assertRedirect(route('guru.index'));
        $this->assertDatabaseHas('guru', ['id_guru' => $guru->id_guru, 'nama' => 'Dr. Ahmad Fauzi, M.Kom.']);
    }

    public function test_guru_destroy_deletes_record(): void
    {
        $guru = Guru::create(['nama' => 'Guru Sementara']);

        $response = $this->delete(route('guru.destroy', $guru));
        $response->assertRedirect(route('guru.index'));
        $this->assertDatabaseMissing('guru', ['id_guru' => $guru->id_guru]);
    }

    // ==========================================
    // 3. KELAS CRUD TESTS
    // ==========================================

    public function test_kelas_index_returns_ok(): void
    {
        $response = $this->get(route('kelas.index'));
        $response->assertStatus(200);
        $response->assertViewIs('kelas.index');
    }

    public function test_kelas_create_returns_ok(): void
    {
        $response = $this->get(route('kelas.create'));
        $response->assertStatus(200);
        $response->assertViewIs('kelas.create');
    }

    public function test_kelas_store_creates_record(): void
    {
        $response = $this->post(route('kelas.store'), ['nama_kelas' => 'X MIPA 1']);
        $response->assertRedirect(route('kelas.index'));
        $this->assertDatabaseHas('kelas', ['nama_kelas' => 'X MIPA 1']);
    }

    public function test_kelas_show_returns_ok(): void
    {
        $kelas = Kelas::create(['nama_kelas' => 'XI IPS 2']);

        $response = $this->get(route('kelas.show', $kelas));
        $response->assertStatus(200);
        $response->assertViewIs('kelas.show');
        $response->assertSee('XI IPS 2');
    }

    public function test_kelas_edit_returns_ok(): void
    {
        $kelas = Kelas::create(['nama_kelas' => 'XII BAHASA']);

        $response = $this->get(route('kelas.edit', $kelas));
        $response->assertStatus(200);
        $response->assertViewIs('kelas.edit');
    }

    public function test_kelas_update_modifies_record(): void
    {
        $kelas = Kelas::create(['nama_kelas' => 'X IPA 3']);

        $response = $this->put(route('kelas.update', $kelas), ['nama_kelas' => 'X MIPA 3']);
        $response->assertRedirect(route('kelas.index'));
        $this->assertDatabaseHas('kelas', ['id_kelas' => $kelas->id_kelas, 'nama_kelas' => 'X MIPA 3']);
    }

    public function test_kelas_destroy_deletes_record(): void
    {
        $kelas = Kelas::create(['nama_kelas' => 'Kelas Hapus']);

        $response = $this->delete(route('kelas.destroy', $kelas));
        $response->assertRedirect(route('kelas.index'));
        $this->assertDatabaseMissing('kelas', ['id_kelas' => $kelas->id_kelas]);
    }

    // ==========================================
    // 4. MAPEL CRUD TESTS
    // ==========================================

    public function test_mapel_index_returns_ok(): void
    {
        $response = $this->get(route('mapel.index'));
        $response->assertStatus(200);
        $response->assertViewIs('mapel.index');
    }

    public function test_mapel_create_returns_ok(): void
    {
        $response = $this->get(route('mapel.create'));
        $response->assertStatus(200);
        $response->assertViewIs('mapel.create');
    }

    public function test_mapel_store_creates_record(): void
    {
        $data = [
            'kode_mapel' => 'MAT-X-01',
            'nama_mapel' => 'Matematika Wajib',
            'kategori' => 'Umum',
            'jumlah_jam' => 4,
            'nilai_kktp' => 75,
            'aktif' => true,
        ];

        $response = $this->post(route('mapel.store'), $data);
        $response->assertRedirect(route('mapel.index'));
        $this->assertDatabaseHas('mapel', ['kode_mapel' => 'MAT-X-01', 'nama_mapel' => 'Matematika Wajib']);
    }

    public function test_mapel_show_returns_ok(): void
    {
        $mapel = Mapel::create([
            'kode_mapel' => 'FIS-XI-01',
            'nama_mapel' => 'Fisika Peminatan',
            'jumlah_jam' => 3,
        ]);

        $response = $this->get(route('mapel.show', $mapel));
        $response->assertStatus(200);
        $response->assertViewIs('mapel.show');
        $response->assertSee('Fisika Peminatan');
    }

    public function test_mapel_edit_returns_ok(): void
    {
        $mapel = Mapel::create([
            'kode_mapel' => 'KIM-X-01',
            'nama_mapel' => 'Kimia',
            'jumlah_jam' => 3,
        ]);

        $response = $this->get(route('mapel.edit', $mapel));
        $response->assertStatus(200);
        $response->assertViewIs('mapel.edit');
    }

    public function test_mapel_update_modifies_record(): void
    {
        $mapel = Mapel::create([
            'kode_mapel' => 'BIO-X-01',
            'nama_mapel' => 'Biologi Dasar',
            'jumlah_jam' => 2,
        ]);

        $response = $this->put(route('mapel.update', $mapel), [
            'kode_mapel' => 'BIO-X-01',
            'nama_mapel' => 'Biologi Lanjutan',
            'jumlah_jam' => 4,
        ]);

        $response->assertRedirect(route('mapel.index'));
        $this->assertDatabaseHas('mapel', ['id_mapel' => $mapel->id_mapel, 'nama_mapel' => 'Biologi Lanjutan', 'jumlah_jam' => 4]);
    }

    public function test_mapel_destroy_deletes_record(): void
    {
        $mapel = Mapel::create([
            'kode_mapel' => 'TMP-01',
            'nama_mapel' => 'Mapel Sementara',
            'jumlah_jam' => 1,
        ]);

        $response = $this->delete(route('mapel.destroy', $mapel));
        $response->assertRedirect(route('mapel.index'));
        $this->assertDatabaseMissing('mapel', ['id_mapel' => $mapel->id_mapel]);
    }

    // ==========================================
    // 5. PENDAFTARAN KELAS CRUD TESTS
    // ==========================================

    public function test_pendaftaran_kelas_index_returns_ok(): void
    {
        $response = $this->get(route('pendaftaran-kelas.index'));
        $response->assertStatus(200);
        $response->assertViewIs('pendaftaran-kelas.index');
    }

    public function test_pendaftaran_kelas_create_returns_ok(): void
    {
        $response = $this->get(route('pendaftaran-kelas.create'));
        $response->assertStatus(200);
        $response->assertViewIs('pendaftaran-kelas.create');
    }

    public function test_pendaftaran_kelas_store_creates_record(): void
    {
        $siswa = Siswa::create(['nis' => '20001', 'nama' => 'Anton Wijaya']);
        $kelas = Kelas::create(['nama_kelas' => 'X-A']);

        $data = [
            'nis' => $siswa->nis,
            'id_kelas' => $kelas->id_kelas,
            'tahun' => '2024',
        ];

        $response = $this->post(route('pendaftaran-kelas.store'), $data);
        $response->assertRedirect(route('pendaftaran-kelas.index'));
        $this->assertDatabaseHas('pendaftaran_kelas', ['nis' => '20001', 'id_kelas' => $kelas->id_kelas]);
    }

    public function test_pendaftaran_kelas_show_returns_ok(): void
    {
        $siswa = Siswa::create(['nis' => '20002', 'nama' => 'Citra Kirana']);
        $kelas = Kelas::create(['nama_kelas' => 'X-B']);
        $pendaftaran = PendaftaranKelas::create(['nis' => $siswa->nis, 'id_kelas' => $kelas->id_kelas, 'tahun' => '2024']);

        $response = $this->get(route('pendaftaran-kelas.show', $pendaftaran));
        $response->assertStatus(200);
        $response->assertViewIs('pendaftaran-kelas.show');
        $response->assertSee('Citra Kirana');
    }

    public function test_pendaftaran_kelas_edit_returns_ok(): void
    {
        $siswa = Siswa::create(['nis' => '20003', 'nama' => 'Dodi Pratama']);
        $kelas = Kelas::create(['nama_kelas' => 'X-C']);
        $pendaftaran = PendaftaranKelas::create(['nis' => $siswa->nis, 'id_kelas' => $kelas->id_kelas]);

        $response = $this->get(route('pendaftaran-kelas.edit', $pendaftaran));
        $response->assertStatus(200);
        $response->assertViewIs('pendaftaran-kelas.edit');
    }

    public function test_pendaftaran_kelas_update_modifies_record(): void
    {
        $siswa = Siswa::create(['nis' => '20004', 'nama' => 'Eka Saputra']);
        $kelas1 = Kelas::create(['nama_kelas' => 'X-D']);
        $kelas2 = Kelas::create(['nama_kelas' => 'X-E']);
        $pendaftaran = PendaftaranKelas::create(['nis' => $siswa->nis, 'id_kelas' => $kelas1->id_kelas, 'tahun' => '2023']);

        $response = $this->put(route('pendaftaran-kelas.update', $pendaftaran), [
            'nis' => $siswa->nis,
            'id_kelas' => $kelas2->id_kelas,
            'tahun' => '2024',
        ]);

        $response->assertRedirect(route('pendaftaran-kelas.index'));
        $this->assertDatabaseHas('pendaftaran_kelas', ['id' => $pendaftaran->id, 'id_kelas' => $kelas2->id_kelas, 'tahun' => '2024']);
    }

    public function test_pendaftaran_kelas_destroy_deletes_record(): void
    {
        $siswa = Siswa::create(['nis' => '20005', 'nama' => 'Fajar Sidik']);
        $kelas = Kelas::create(['nama_kelas' => 'X-F']);
        $pendaftaran = PendaftaranKelas::create(['nis' => $siswa->nis, 'id_kelas' => $kelas->id_kelas]);

        $response = $this->delete(route('pendaftaran-kelas.destroy', $pendaftaran));
        $response->assertRedirect(route('pendaftaran-kelas.index'));
        $this->assertDatabaseMissing('pendaftaran_kelas', ['id' => $pendaftaran->id]);
    }

    // ==========================================
    // 6. MENGAJAR CRUD TESTS
    // ==========================================

    public function test_mengajar_index_returns_ok(): void
    {
        $response = $this->get(route('mengajar.index'));
        $response->assertStatus(200);
        $response->assertViewIs('mengajar.index');
    }

    public function test_mengajar_create_returns_ok(): void
    {
        $response = $this->get(route('mengajar.create'));
        $response->assertStatus(200);
        $response->assertViewIs('mengajar.create');
    }

    public function test_mengajar_store_creates_record(): void
    {
        $guru = Guru::create(['nama' => 'Guru Mengajar Test']);
        $mapel = Mapel::create(['kode_mapel' => 'MGR-01', 'nama_mapel' => 'Sosiologi', 'jumlah_jam' => 2]);
        $kelas = Kelas::create(['nama_kelas' => 'XI SOS']);

        $data = [
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas->id_kelas,
            'tahun_ajaran' => '2024/2025',
        ];

        $response = $this->post(route('mengajar.store'), $data);
        $response->assertRedirect(route('mengajar.index'));
        $this->assertDatabaseHas('mengajar', ['id_guru' => $guru->id_guru, 'id_mapel' => $mapel->id_mapel, 'id_kelas' => $kelas->id_kelas]);
    }

    public function test_mengajar_show_returns_ok(): void
    {
        $guru = Guru::create(['nama' => 'Guru Show Test']);
        $mapel = Mapel::create(['kode_mapel' => 'MGR-02', 'nama_mapel' => 'Ekonomi', 'jumlah_jam' => 2]);
        $kelas = Kelas::create(['nama_kelas' => 'XI EKO']);
        $mengajar = Mengajar::create([
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas->id_kelas,
        ]);

        $response = $this->get(route('mengajar.show', $mengajar));
        $response->assertStatus(200);
        $response->assertViewIs('mengajar.show');
        $response->assertSee('Guru Show Test');
    }

    public function test_mengajar_edit_returns_ok(): void
    {
        $guru = Guru::create(['nama' => 'Guru Edit Test']);
        $mapel = Mapel::create(['kode_mapel' => 'MGR-03', 'nama_mapel' => 'Geografi', 'jumlah_jam' => 2]);
        $kelas = Kelas::create(['nama_kelas' => 'XI GEO']);
        $mengajar = Mengajar::create([
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas->id_kelas,
        ]);

        $response = $this->get(route('mengajar.edit', $mengajar));
        $response->assertStatus(200);
        $response->assertViewIs('mengajar.edit');
    }

    public function test_mengajar_update_modifies_record(): void
    {
        $guru = Guru::create(['nama' => 'Guru Update Test']);
        $mapel = Mapel::create(['kode_mapel' => 'MGR-04', 'nama_mapel' => 'Sejarah', 'jumlah_jam' => 2]);
        $kelas1 = Kelas::create(['nama_kelas' => 'X SEJ 1']);
        $kelas2 = Kelas::create(['nama_kelas' => 'X SEJ 2']);
        $mengajar = Mengajar::create([
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas1->id_kelas,
            'tahun_ajaran' => '2023/2024',
        ]);

        $response = $this->put(route('mengajar.update', $mengajar), [
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas2->id_kelas,
            'tahun_ajaran' => '2024/2025',
        ]);

        $response->assertRedirect(route('mengajar.index'));
        $this->assertDatabaseHas('mengajar', ['id_mengajar' => $mengajar->id_mengajar, 'id_kelas' => $kelas2->id_kelas]);
    }

    public function test_mengajar_destroy_deletes_record(): void
    {
        $guru = Guru::create(['nama' => 'Guru Hapus']);
        $mapel = Mapel::create(['kode_mapel' => 'MGR-05', 'nama_mapel' => 'Seni', 'jumlah_jam' => 2]);
        $kelas = Kelas::create(['nama_kelas' => 'X SENI']);
        $mengajar = Mengajar::create([
            'id_guru' => $guru->id_guru,
            'id_mapel' => $mapel->id_mapel,
            'id_kelas' => $kelas->id_kelas,
        ]);

        $response = $this->delete(route('mengajar.destroy', $mengajar));
        $response->assertRedirect(route('mengajar.index'));
        $this->assertDatabaseMissing('mengajar', ['id_mengajar' => $mengajar->id_mengajar]);
    }

    // ==========================================
    // 7. NILAI CRUD TESTS
    // ==========================================

    public function test_nilai_index_returns_ok(): void
    {
        $response = $this->get(route('nilai.index'));
        $response->assertStatus(200);
        $response->assertViewIs('nilai.index');
    }

    public function test_nilai_create_returns_ok(): void
    {
        $response = $this->get(route('nilai.create'));
        $response->assertStatus(200);
        $response->assertViewIs('nilai.create');
    }

    public function test_nilai_store_creates_record(): void
    {
        $siswa = Siswa::create(['nis' => '30001', 'nama' => 'Gita Gutawa']);
        $mapel = Mapel::create(['kode_mapel' => 'NIL-01', 'nama_mapel' => 'Musik', 'jumlah_jam' => 2]);

        $data = [
            'nis' => $siswa->nis,
            'id_mapel' => $mapel->id_mapel,
            'semester' => 1,
            'nilai' => 88.50,
        ];

        $response = $this->post(route('nilai.store'), $data);
        $response->assertRedirect(route('nilai.index'));
        $this->assertDatabaseHas('nilai', ['nis' => '30001', 'id_mapel' => $mapel->id_mapel, 'nilai' => 88.50]);
    }

    public function test_nilai_show_returns_ok(): void
    {
        $siswa = Siswa::create(['nis' => '30002', 'nama' => 'Hendra Setiawan']);
        $mapel = Mapel::create(['kode_mapel' => 'NIL-02', 'nama_mapel' => 'Penjasorkes', 'jumlah_jam' => 2]);
        $nilai = Nilai::create([
            'nis' => $siswa->nis,
            'id_mapel' => $mapel->id_mapel,
            'semester' => 1,
            'nilai' => 90.00,
        ]);

        $response = $this->get(route('nilai.show', $nilai));
        $response->assertStatus(200);
        $response->assertViewIs('nilai.show');
        $response->assertSee('Hendra Setiawan');
    }

    public function test_nilai_edit_returns_ok(): void
    {
        $siswa = Siswa::create(['nis' => '30003', 'nama' => 'Indra Wijaya']);
        $mapel = Mapel::create(['kode_mapel' => 'NIL-03', 'nama_mapel' => 'Bahasa Inggris', 'jumlah_jam' => 2]);
        $nilai = Nilai::create([
            'nis' => $siswa->nis,
            'id_mapel' => $mapel->id_mapel,
            'semester' => 1,
            'nilai' => 78.00,
        ]);

        $response = $this->get(route('nilai.edit', $nilai));
        $response->assertStatus(200);
        $response->assertViewIs('nilai.edit');
    }

    public function test_nilai_update_modifies_record(): void
    {
        $siswa = Siswa::create(['nis' => '30004', 'nama' => 'Joko Anwar']);
        $mapel = Mapel::create(['kode_mapel' => 'NIL-04', 'nama_mapel' => 'Informatika', 'jumlah_jam' => 2]);
        $nilai = Nilai::create([
            'nis' => $siswa->nis,
            'id_mapel' => $mapel->id_mapel,
            'semester' => 1,
            'nilai' => 80.00,
        ]);

        $response = $this->put(route('nilai.update', $nilai), [
            'nis' => $siswa->nis,
            'id_mapel' => $mapel->id_mapel,
            'semester' => 1,
            'nilai' => 95.50,
        ]);

        $response->assertRedirect(route('nilai.index'));
        $this->assertDatabaseHas('nilai', ['id_nilai' => $nilai->id_nilai, 'nilai' => 95.50]);
    }

    public function test_nilai_destroy_deletes_record(): void
    {
        $siswa = Siswa::create(['nis' => '30005', 'nama' => 'Kartika Putri']);
        $mapel = Mapel::create(['kode_mapel' => 'NIL-05', 'nama_mapel' => 'Prakarya', 'jumlah_jam' => 2]);
        $nilai = Nilai::create([
            'nis' => $siswa->nis,
            'id_mapel' => $mapel->id_mapel,
            'semester' => 1,
            'nilai' => 82.00,
        ]);

        $response = $this->delete(route('nilai.destroy', $nilai));
        $response->assertRedirect(route('nilai.index'));
        $this->assertDatabaseMissing('nilai', ['id_nilai' => $nilai->id_nilai]);
    }

    // ==========================================
    // 8. LOG AKTIVITAS (READ-ONLY) TESTS
    // ==========================================

    public function test_log_aktivitas_index_returns_ok(): void
    {
        $response = $this->get(route('log-aktivitas.index'));
        $response->assertStatus(200);
        $response->assertViewIs('log-aktivitas.index');
    }

    public function test_log_aktivitas_show_returns_ok(): void
    {
        $log = LogAktivitas::create([
            'aktivitas' => 'User login ke sistem',
            'jenis_aktivitas' => 'AUTH',
            'waktu' => now(),
        ]);

        $response = $this->get(route('log-aktivitas.show', $log));
        $response->assertStatus(200);
        $response->assertViewIs('log-aktivitas.show');
        $response->assertSee('User login ke sistem');
    }

    public function test_log_aktivitas_cannot_be_created_manually(): void
    {
        $response = $this->get('/log-aktivitas/create');
        $response->assertStatus(404);

        $responsePost = $this->post('/log-aktivitas', [
            'aktivitas' => 'Test Log',
            'jenis_aktivitas' => 'MANUAL',
        ]);
        $responsePost->assertStatus(405);
    }
}
