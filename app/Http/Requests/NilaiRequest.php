<?php

namespace App\Http\Requests;

use App\Models\Nilai;
use Illuminate\Foundation\Http\FormRequest;

class NilaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        $nilai = $this->route('nilai');

        if ($this->isMethod('POST')) {
            return $this->user()?->can('create', Nilai::class) ?? false;
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->user()?->can('update', $nilai) ?? false;
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
            'id_mapel' => ['required', 'integer', 'exists:mapel,id_mapel'],
            'semester' => ['nullable', 'integer'],
            'nilai' => ['nullable', 'numeric', 'between:0,100'],
        ];
    }
}
