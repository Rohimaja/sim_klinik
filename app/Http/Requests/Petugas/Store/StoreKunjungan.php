<?php

namespace App\Http\Requests\Petugas\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class StoreKunjungan extends FormRequest
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
            'nik' => 'required|max:16|regex:/^[0-9]+$/',
            'no_bpjs' => 'min:13|regex:/^[0-9]+$/',
            'nama' => 'required|max:100|regex:/^[A-Za-z\s]+$/',
            'jenis_pasien' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|max:100|regex:/^[A-Za-z\s]+$/',
            'tgl_lahir' => 'required|before:today',
            'no_telp' => 'required|max:20|regex:/^[0-9]+$/',
            'email' => ['required','email:rfc,dns','max:100'],
            'alamat' => 'required|max:200',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // opsional: validasi foto
            'poli_id' => 'required',
            'dokter_id' => 'nullable',
            'tgl_kunjungan' => 'required',
            'keluhan_awal' => 'required|max:200',
        ];
    }

    public function messages(){
        return [
            'nik.required' => 'NIK wajib diisi',
            'nik.max' => 'NIK maksimal 16 karakter',
            'nik.regex' => 'NIK hanya boleh berisi angka',

            'no_bpjs.min' => 'No BPJS minimal 13 karakter',
            'no_bpjs.regex' => 'No BPJS hanya boleh angka',

            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Nama maksimal 100 karakter',
            'nama.regex' =>'Nama hanya boleh mengandung huruf',

            'jenis_pasien.required' => 'Jenis Pasien harus dipilih',

            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih',

            'tempat_lahir.required' => 'Tempat Lahir tidak boleh kosong',
            'tempat_lahir.max' => 'Tempat Lahir tidak boleh melebihi 100 karakter',
            'tempat_lahir.regex' =>'Nama hanya boleh mengandung huruf',

            'tgl_lahir.required' => 'Tanggal Lahir wajib diisi',
            'tgl_lahir.before' => 'Tanggal Lahir harus sebelum hari ini',


            'no_telp.required' => 'Nomor Telepon wajib diisi',
            'no_telp.max' => 'Nomor Telepon maksimal 20 karakter',
            'no_telp.regex' => 'Nomor Telepon hanya boleh berisi angka',

            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah digunakan',

            'alamat.required' => 'Alamat tidak boleh kosong',
            'alamat.max' => 'Alamat maksimal 200 karakter',

            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus jpeg, png, atau jpg',
            'foto.max' => 'Ukuran gambar maksimal 2MB',

            'poli_id.required' => 'Pilih Poli tujuan terlebih dahulu',

            'tgl_kunjungan.required' => 'Pilih tanggal berkunjung dahulu',

            'keluhan_awal.required' => 'Keluhan tidak boleh kosong',
            'keluhan_awal.max' => 'Keluhan maksimal 200 karakter',



        ];
    }
}
