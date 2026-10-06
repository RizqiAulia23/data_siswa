<?php

namespace App\Http\Requests;

use App\Models\Guru;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        $guru = $this->route('guru');

        if ($this->isMethod('POST')) {
            return $this->user()?->can('create', Guru::class) ?? false;
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->user()?->can('update', $guru) ?? false;
        }

        return true;
    }

    /**
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        $guru = $this->route('guru');
        $guruId = $guru instanceof Guru ? $guru->id_guru : $guru;

        return [
            'nip' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('guru', 'nip')->ignore($guruId, 'id_guru'),
            ],
            'nama' => ['nullable', 'string', 'max:100'],
            'jenis_kelamin' => ['nullable', 'string', 'max:1', Rule::in(['L', 'P'])],
            'alamat' => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jam_masuk' => [
                'nullable',
                'string',
                'regex:/^([01][0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/',
            ],
            'gaji' => ['nullable', 'numeric', 'between:0,99999999.99'],
            'aktif' => ['nullable', 'boolean'],
            'nomor_hp' => ['nullable', 'string', 'max:15'],
        ];
    }
}
