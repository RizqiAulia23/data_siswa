<?php

namespace App\Http\Requests;

use App\Models\Siswa;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        $siswa = $this->route('siswa');

        if ($this->isMethod('POST')) {
            return $this->user()?->can('create', Siswa::class) ?? false;
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->user()?->can('update', $siswa) ?? false;
        }

        return true;
    }

    /**
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        $siswa = $this->route('siswa');
        $nis = $siswa instanceof Siswa ? $siswa->nis : $siswa;

        return [
            'nis' => [
                'required',
                'string',
                'max:10',
                Rule::unique('siswa', 'nis')->ignore($nis, 'nis'),
            ],
            'nama' => ['required', 'string', 'max:100'],
            'alamat' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:100'],
            'nomor_hp' => ['nullable', 'string', 'max:15'],
            'agama' => ['nullable', 'string', 'max:30'],
            'jenis_kelamin' => ['nullable', 'string', Rule::in(['L', 'P'])],
        ];
    }
}
