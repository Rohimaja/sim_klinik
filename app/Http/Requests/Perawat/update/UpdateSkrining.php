<?php

namespace App\Http\Requests\Perawat\update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateSkrining extends FormRequest
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
            'sistol' => 'required|numeric|min:50|max:250',
            'diastolik' => 'required|numeric|min:30|max:150',
            'suhu' => 'required|numeric|min:30|max:45',
            'berat_badan' => 'required|numeric|min:1|max:300',
            'tinggi_badan' => 'required|numeric|min:30|max:250',
            'keluhan_utama' => 'nullable|string|max:255',
            'kunjungan_id' => 'required|exists:kunjungan,id',
        ];
    }

    public function messages()
    {
        return [

            // SISTOL
            'sistol.required' => 'Sistol wajib diisi.',
            'sistol.numeric'  => 'Sistol harus berupa angka.',
            'sistol.min'      => 'Sistol tidak boleh kurang dari 50.',
            'sistol.max'      => 'Sistol tidak boleh lebih dari 250.',

            // DIASTOLIK
            'diastolik.required' => 'Diastolik wajib diisi.',
            'diastolik.numeric'  => 'Diastolik harus berupa angka.',
            'diastolik.min'      => 'Diastolik tidak boleh kurang dari 30.',
            'diastolik.max'      => 'Diastolik tidak boleh lebih dari 150.',

            // SUHU
            'suhu.required' => 'Suhu wajib diisi.',
            'suhu.numeric'  => 'Suhu harus berupa angka.',
            'suhu.min'      => 'Suhu tidak boleh kurang dari 30°C.',
            'suhu.max'      => 'Suhu tidak boleh lebih dari 45°C.',

            // BERAT BADAN
            'berat_badan.required' => 'Berat badan wajib diisi.',
            'berat_badan.numeric'  => 'Berat badan harus berupa angka.',
            'berat_badan.min'      => 'Berat badan tidak boleh kurang dari 1 kg.',
            'berat_badan.max'      => 'Berat badan tidak boleh lebih dari 300 kg.',

            // TINGGI BADAN
            'tinggi_badan.required' => 'Tinggi badan wajib diisi.',
            'tinggi_badan.numeric'  => 'Tinggi badan harus berupa angka.',
            'tinggi_badan.min'      => 'Tinggi badan tidak boleh kurang dari 30 cm.',
            'tinggi_badan.max'      => 'Tinggi badan tidak boleh lebih dari 250 cm.',

            // KELUHAN UTAMA
            'keluhan_utama.max' => 'Keluhan utama maksimal 255 karakter.',

            // ANTRIAN POLI
            'kunjungan_id.required' => 'Data Kunjungan tidak ditemukan.',
            'kunjungan_id.exists'   => 'Kunjungan tidak valid.',
        ];
    }

}
