<?php

namespace App\Http\Requests\Dokter\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdatePemeriksaan extends FormRequest
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
            'diagnosa'       => 'required|string|max:255',
            'tindakan'       => 'required|string|max:255',
            'catatan'        => 'nullable|string|max:255',
            'tgl_periksa'    => 'required|date',
            'antrian_poli_id' => 'required|exists:antrian_poli,id',
        ];
    }

    public function messages()
    {
        return [

            // Diagnosa
            'diagnosa.required' => 'Diagnosa pasien wajib diisi.',
            'diagnosa.string'   => 'Diagnosa harus berupa teks.',
            'diagnosa.max'      => 'Diagnosa maksimal 255 karakter.',

            // Tindakan
            'tindakan.required' => 'Tindakan untuk pasien wajib diisi.',
            'tindakan.string'   => 'Tindakan harus berupa teks.',
            'tindakan.max'      => 'Tindakan maksimal 255 karakter.',

            // Catatan
            'catatan.string'   => 'Catatan harus berupa teks.',
            'catatan.max'      => 'Catatan maksimal 255 karakter.',

            // Tanggal Periksa
            'tgl_periksa.required' => 'Tanggal dan waktu pemeriksaan wajib diisi.',
            'tgl_periksa.date'     => 'Format tanggal pemeriksaan tidak valid.',

            // ANTRIAN POLI
            'antrian_poli_id.required' => 'Data Antrian Poli tidak ditemukan.',
            'antrian_poli_id.exists'   => 'Data Antrian Poli tidak valid.',
        ];
    }

}
