<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;


class StoreMasterJadwal extends FormRequest
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
            'dokter_id' => 'required',
            'poli_id' => 'required',
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_akhir' => 'required|after:jam_mulai',
            'keterangan' => 'regex:/^[A-Za-z0-9\s]+$/',
        ];
    }

    public function messages(){
        return [
            'dokter_id.required' => 'Pilih Dokter Terlebih dahulu',

            'poli_id.required' => 'Pilih Poli Terlebih dahulu',

            'hari.required' => 'Pilih Hari Terlebih dahulu',

            'jam_mulai.required' => 'Pilih Jam Awal Terlebih dahulu',

            'jam_akhir.required' => 'Pilih Jam Selesai Terlebih dahulu',
            'jam_akhir.after' => 'Jam Selesai harus lebih besar',

            'keterangan.regex' =>'Keterangan Tindakan tidak boleh mengandung simbol',
        ];
    }
}
