<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $primaryKey = 'id_kelas';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'nama_kelas',
    ];

    /**
     * @return HasMany<PendaftaranKelas, $this>
     */
    public function pendaftaranKelas(): HasMany
    {
        return $this->hasMany(PendaftaranKelas::class, 'id_kelas', 'id_kelas');
    }

    /**
     * @return HasMany<Mengajar, $this>
     */
    public function mengajar(): HasMany
    {
        return $this->hasMany(Mengajar::class, 'id_kelas', 'id_kelas');
    }
}
