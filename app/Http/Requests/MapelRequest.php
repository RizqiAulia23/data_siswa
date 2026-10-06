<?php

namespace App\Http\Requests;

use App\Models\Mapel;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapelRequest extends FormRequest
{
    public function authorize(): bool
    {
        $mapel = $this->route('mapel');

        if ($this->isMethod('POST')) {
            return $this->user()?->can('create', Mapel::class) ?? false;
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->user()?->can('update', $mapel) ?? false;
        }

        return true;
    }

    /**
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        $mapel = $this->route('mapel');
        $mapelId = $mapel instanceof Mapel ? $mapel->id_mapel : $mapel;

        return [
            'kode_mapel' => [
                'required',
                'string',
                'max:50',
                Rule::unique('mapel', 'kode_mapel')->ignore($mapelId, 'id_mapel'),
            ],
            'nama_mapel' => ['required', 'string', 'max:100'],
            'kategori' => ['nullable', 'string', 'max:50'],
            'jumlah_jam' => ['required', 'integer', 'gt:0'],
            'nilai_kktp' => ['nullable', 'integer', 'min:0', 'max:100'],
            'aktif' => ['nullable', 'boolean'],
            'deskripsi' => ['nullable', 'string'],
            'semester' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
