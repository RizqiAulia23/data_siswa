<?php

namespace Tests\Unit;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\LogAktivitas;
use App\Models\Mapel;
use App\Models\Mengajar;
use App\Models\Nilai;
use App\Models\PendaftaranKelas;
use App\Models\Siswa;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    public function test_guru_model_configuration_and_relationships(): void
    {
        $guru = new Guru;

        $this->assertSame('guru', $guru->getTable());
        $this->assertSame('id_guru', $guru->getKeyName());
        $this->assertTrue($guru->incrementing);
        $this->assertSame('int', $guru->getKeyType());
        $this->assertFalse($guru->timestamps);

        $relation = $guru->mengajar();
        $this->assertInstanceOf(HasMany::class, $relation);
        $this->assertInstanceOf(Mengajar::class, $relation->getRelated());
        $this->assertSame('id_guru', $relation->getForeignKeyName());
        $this->assertSame('id_guru', $relation->getLocalKeyName());
    }

    public function test_kelas_model_configuration_and_relationships(): void
    {
        $kelas = new Kelas;

        $this->assertSame('kelas', $kelas->getTable());
        $this->assertSame('id_kelas', $kelas->getKeyName());
        $this->assertTrue($kelas->incrementing);
        $this->assertSame('int', $kelas->getKeyType());
        $this->assertFalse($kelas->timestamps);

        $relPendaftaran = $kelas->pendaftaranKelas();
        $this->assertInstanceOf(HasMany::class, $relPendaftaran);
        $this->assertInstanceOf(PendaftaranKelas::class, $relPendaftaran->getRelated());
        $this->assertSame('id_kelas', $relPendaftaran->getForeignKeyName());
        $this->assertSame('id_kelas', $relPendaftaran->getLocalKeyName());

        $relMengajar = $kelas->mengajar();
        $this->assertInstanceOf(HasMany::class, $relMengajar);
        $this->assertInstanceOf(Mengajar::class, $relMengajar->getRelated());
        $this->assertSame('id_kelas', $relMengajar->getForeignKeyName());
        $this->assertSame('id_kelas', $relMengajar->getLocalKeyName());
    }

    public function test_mapel_model_configuration_and_relationships(): void
    {
        $mapel = new Mapel;

        $this->assertSame('mapel', $mapel->getTable());
        $this->assertSame('id_mapel', $mapel->getKeyName());
        $this->assertTrue($mapel->incrementing);
        $this->assertSame('int', $mapel->getKeyType());
        $this->assertTrue($mapel->timestamps);

        $relMengajar = $mapel->mengajar();
        $this->assertInstanceOf(HasMany::class, $relMengajar);
        $this->assertInstanceOf(Mengajar::class, $relMengajar->getRelated());
        $this->assertSame('id_mapel', $relMengajar->getForeignKeyName());
        $this->assertSame('id_mapel', $relMengajar->getLocalKeyName());

        $relNilai = $mapel->nilai();
        $this->assertInstanceOf(HasMany::class, $relNilai);
        $this->assertInstanceOf(Nilai::class, $relNilai->getRelated());
        $this->assertSame('id_mapel', $relNilai->getForeignKeyName());
        $this->assertSame('id_mapel', $relNilai->getLocalKeyName());
    }

    public function test_mengajar_model_configuration_and_relationships(): void
    {
        $mengajar = new Mengajar;

        $this->assertSame('mengajar', $mengajar->getTable());
        $this->assertSame('id_mengajar', $mengajar->getKeyName());
        $this->assertTrue($mengajar->incrementing);
        $this->assertSame('int', $mengajar->getKeyType());
        $this->assertFalse($mengajar->timestamps);

        $relGuru = $mengajar->guru();
        $this->assertInstanceOf(BelongsTo::class, $relGuru);
        $this->assertInstanceOf(Guru::class, $relGuru->getRelated());
        $this->assertSame('id_guru', $relGuru->getForeignKeyName());
        $this->assertSame('id_guru', $relGuru->getOwnerKeyName());

        $relMapel = $mengajar->mapel();
        $this->assertInstanceOf(BelongsTo::class, $relMapel);
        $this->assertInstanceOf(Mapel::class, $relMapel->getRelated());
        $this->assertSame('id_mapel', $relMapel->getForeignKeyName());
        $this->assertSame('id_mapel', $relMapel->getOwnerKeyName());

        $relKelas = $mengajar->kelas();
        $this->assertInstanceOf(BelongsTo::class, $relKelas);
        $this->assertInstanceOf(Kelas::class, $relKelas->getRelated());
        $this->assertSame('id_kelas', $relKelas->getForeignKeyName());
        $this->assertSame('id_kelas', $relKelas->getOwnerKeyName());
    }

    public function test_nilai_model_configuration_and_relationships(): void
    {
        $nilai = new Nilai;

        $this->assertSame('nilai', $nilai->getTable());
        $this->assertSame('id_nilai', $nilai->getKeyName());
        $this->assertTrue($nilai->incrementing);
        $this->assertSame('int', $nilai->getKeyType());
        $this->assertFalse($nilai->timestamps);

        $relSiswa = $nilai->siswa();
        $this->assertInstanceOf(BelongsTo::class, $relSiswa);
        $this->assertInstanceOf(Siswa::class, $relSiswa->getRelated());
        $this->assertSame('nis', $relSiswa->getForeignKeyName());
        $this->assertSame('nis', $relSiswa->getOwnerKeyName());

        $relMapel = $nilai->mapel();
        $this->assertInstanceOf(BelongsTo::class, $relMapel);
        $this->assertInstanceOf(Mapel::class, $relMapel->getRelated());
        $this->assertSame('id_mapel', $relMapel->getForeignKeyName());
        $this->assertSame('id_mapel', $relMapel->getOwnerKeyName());
    }

    public function test_pendaftaran_kelas_model_configuration_and_relationships(): void
    {
        $pendaftaran = new PendaftaranKelas;

        $this->assertSame('pendaftaran_kelas', $pendaftaran->getTable());
        $this->assertSame('id', $pendaftaran->getKeyName());
        $this->assertTrue($pendaftaran->incrementing);
        $this->assertSame('int', $pendaftaran->getKeyType());
        $this->assertFalse($pendaftaran->timestamps);

        $relSiswa = $pendaftaran->siswa();
        $this->assertInstanceOf(BelongsTo::class, $relSiswa);
        $this->assertInstanceOf(Siswa::class, $relSiswa->getRelated());
        $this->assertSame('nis', $relSiswa->getForeignKeyName());
        $this->assertSame('nis', $relSiswa->getOwnerKeyName());

        $relKelas = $pendaftaran->kelas();
        $this->assertInstanceOf(BelongsTo::class, $relKelas);
        $this->assertInstanceOf(Kelas::class, $relKelas->getRelated());
        $this->assertSame('id_kelas', $relKelas->getForeignKeyName());
        $this->assertSame('id_kelas', $relKelas->getOwnerKeyName());
    }

    public function test_siswa_model_configuration_and_relationships(): void
    {
        $siswa = new Siswa;

        $this->assertSame('siswa', $siswa->getTable());
        $this->assertSame('nis', $siswa->getKeyName());
        $this->assertFalse($siswa->incrementing);
        $this->assertSame('string', $siswa->getKeyType());
        $this->assertFalse($siswa->timestamps);

        $relPendaftaran = $siswa->pendaftaranKelas();
        $this->assertInstanceOf(HasMany::class, $relPendaftaran);
        $this->assertInstanceOf(PendaftaranKelas::class, $relPendaftaran->getRelated());
        $this->assertSame('nis', $relPendaftaran->getForeignKeyName());
        $this->assertSame('nis', $relPendaftaran->getLocalKeyName());

        $relNilai = $siswa->nilai();
        $this->assertInstanceOf(HasMany::class, $relNilai);
        $this->assertInstanceOf(Nilai::class, $relNilai->getRelated());
        $this->assertSame('nis', $relNilai->getForeignKeyName());
        $this->assertSame('nis', $relNilai->getLocalKeyName());
    }

    public function test_log_aktivitas_model_configuration(): void
    {
        $log = new LogAktivitas;

        $this->assertSame('log_aktivitas', $log->getTable());
        $this->assertSame('id_log', $log->getKeyName());
        $this->assertTrue($log->incrementing);
        $this->assertSame('int', $log->getKeyType());
        $this->assertFalse($log->timestamps);
    }
}
