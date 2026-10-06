<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $primaryKey = 'nis';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'nis',
        'nama',
        'alamat',
        'email',
        'nomor_hp',
        'agama',
        'jenis_kelamin',
    ];

    /**
     * @return HasMany<PendaftaranKelas, $this>
     */
    public function pendaftaranKelas(): HasMany
    {
        return $this->hasMany(PendaftaranKelas::class, 'nis', 'nis');
    }

    /**
     * @return HasMany<Nilai, $this>
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'nis', 'nis');
    }
}
