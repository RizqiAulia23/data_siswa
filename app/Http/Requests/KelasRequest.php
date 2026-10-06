<?php

namespace App\Http\Requests;

use App\Models\Kelas;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        $kelas = $this->route('kelas') ?? $this->route('kela');

        if ($this->isMethod('POST')) {
            return $this->user()?->can('create', Kelas::class) ?? false;
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->user()?->can('update', $kelas) ?? false;
        }

        return true;
    }

    /**
     * @return array<string, array<int, mixed>|string>
     */
    public function rules(): array
    {
        $kelas = $this->route('kelas') ?? $this->route('kela');
        $kelasId = $kelas instanceof Kelas ? $kelas->id_kelas : $kelas;

        return [
            'nama_kelas' => [
                'nullable',
                'string',
                'max:20',
                Rule::unique('kelas', 'nama_kelas')->ignore($kelasId, 'id_kelas'),
            ],
        ];
    }
}
