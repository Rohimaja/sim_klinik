<?php

namespace App\Http\Requests\Admin\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateMasterObat extends FormRequest
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

        $id = $this->route('master_obat');

        return [
            'nama' => ['required','max:70','regex:/^[A-Za-z0-9\s]+$/',Rule::unique('obat', 'nama')->ignore($id)],
            // 'harga' => 'regex:/^[0-9\s]+$/',
            'keterangan' => 'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Nama Obat tidak boleh kosong',
            'nama.max' => 'Nama Obat maksimal 100 karakter',
            'nama.unique' => 'Nama Obat sudah terdaftar',
            'nama.regex' =>'Nama Obat tidak boleh mengandung simbol',

            // 'status.required' => 'Status harus dipilih',
            // 'harga.regex' =>'Harga obat hanya boleh mengandung angka',

            'keterangan.regex' =>'Keterangan Obat tidak boleh mengandung simbol',
        ];
    }
}
