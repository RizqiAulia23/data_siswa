<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guru extends Model
{
    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'alamat',
        'tanggal_lahir',
        'jam_masuk',
        'gaji',
        'aktif',
        'nomor_hp',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'gaji' => 'decimal:2',
            'aktif' => 'boolean',
        ];
    }

    /**
     * @return HasMany<Mengajar, $this>
     */
    public function mengajar(): HasMany
    {
        return $this->hasMany(Mengajar::class, 'id_guru', 'id_guru');
    }
}
