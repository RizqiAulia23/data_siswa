<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mapel extends Model
{
    protected $table = 'mapel';

    protected $primaryKey = 'id_mapel';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
        'kategori',
        'jumlah_jam',
        'nilai_kktp',
        'aktif',
        'deskripsi',
        'semester',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'jumlah_jam' => 'integer',
            'nilai_kktp' => 'integer',
            'semester' => 'integer',
            'aktif' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<Mengajar, $this>
     */
    public function mengajar(): HasMany
    {
        return $this->hasMany(Mengajar::class, 'id_mapel', 'id_mapel');
    }

    /**
     * @return HasMany<Nilai, $this>
     */
    public function nilai(): HasMany
    {
        return $this->hasMany(Nilai::class, 'id_mapel', 'id_mapel');
    }
}
