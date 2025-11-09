<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreMasterPoli extends FormRequest
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
            // 'status' => 'required',
            'keterangan' => 'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Nama Poli tidak boleh kosong',
            'nama.max' => 'Nama Poli maksimal 100 karakter',
            'nama.regex' =>'Nama Poli tidak boleh mengandung simbol',

            // 'status.required' => 'Status harus dipilih',

            'keterangan.regex' =>'Keterangan Poli tidak boleh mengandung simbol',
        ];
    }
}
