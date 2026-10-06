<?php

namespace App\Http\Requests;

use App\Models\Mengajar;
use Illuminate\Foundation\Http\FormRequest;

class MengajarRequest extends FormRequest
{
    public function authorize(): bool
    {
        $mengajar = $this->route('mengajar');

        if ($this->isMethod('POST')) {
            return $this->user()?->can('create', Mengajar::class) ?? false;
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            return $this->user()?->can('update', $mengajar) ?? false;
        }

        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'id_guru' => ['required', 'integer', 'exists:guru,id_guru'],
            'id_mapel' => ['required', 'integer', 'exists:mapel,id_mapel'],
            'id_kelas' => ['required', 'integer', 'exists:kelas,id_kelas'],
            'tahun_ajaran' => ['nullable', 'string', 'regex:/^\d{4}(\/\d{4})?$/'],
        ];
    }
}
