<?php

namespace App\Http\Requests\Admin\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateMasterTindakan extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $id = $this->route('master_tindakan');

        return [
            'nama' => ['required','max:70','regex:/^[A-Za-z0-9\s]+$/',Rule::unique('tindakan', 'nama')->ignore($id)],
            'tarif' => 'required',
            'keterangan' => 'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Tindakan tidak boleh kosong',
            'nama.max' => 'Tindakan maksimal 100 karakter',
            'nama.unique' => 'Tindakan sudah terdaftar',
            'nama.regex' =>'Tindakan tidak boleh mengandung simbol',

            // 'status.required' => 'Status harus dipilih',

            'keterangan.regex' =>'Keterangan Poli tidak boleh mengandung simbol',
        ];
    }
}
