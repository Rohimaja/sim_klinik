<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreMasterObat extends FormRequest
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
            // 'harga' => 'regex:/^[0-9\s]+$/',
            'keterangan' => 'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public function messages(){
        return [
            'nama.required' => 'Nama obat tidak boleh kosong',
            'nama.max' => 'Nama obat maksimal 100 karakter',
            'nama.regex' =>'Nama obat tidak boleh mengandung simbol',

            // 'status.required' => 'Status harus dipilih',
            // 'harga.regex' =>'Harga obat hanya boleh mengandung angka',

            'keterangan.regex' =>'Keterangan obat tidak boleh mengandung simbol',
        ];
    }
}
