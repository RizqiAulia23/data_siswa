<?php

namespace App\Http\Requests;

use App\Models\PendaftaranKelas;
use Illuminate\Foundation\Http\FormRequest;

class PendaftaranKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        $pendaftaranKelas = $this->route('pendaftaranKelas') ?? $this->route('pendaftaran-kelas');

        if ($this->isMethod('POST')) {
            return $this->user()?->can('create', PendaftaranKelas::class) ?? false;
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->user()?->can('update', $pendaftaranKelas) ?? false;
        }

        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'nis' => ['required', 'string', 'max:10', 'exists:siswa,nis'],
            'id_kelas' => ['required', 'integer', 'exists:kelas,id_kelas'],
            'tahun' => ['nullable', 'string', 'regex:/^\d{4}$/'],
        ];
    }
}
