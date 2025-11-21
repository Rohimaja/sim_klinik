<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;


class StoreMasterTindakan extends FormRequest
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

        // $id = $id ??  $this->route('master_dosen');

        return [
            'nama' => 'required|max:70|regex:/^[A-Za-z0-9\s]+$/',
            'tarif' => 'required',
            'keterangan' => 'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Tindakan tidak boleh kosong',
            'nama.max' => 'Tindakan maksimal 100 karakter',
            'nama.regex' =>'Tindakan tidak boleh mengandung simbol',

            'tarif.required' => 'Tentukan tarif untuk tindakan',

            'keterangan.regex' =>'Keterangan Tindakan tidak boleh mengandung simbol',
        ];
    }
}
