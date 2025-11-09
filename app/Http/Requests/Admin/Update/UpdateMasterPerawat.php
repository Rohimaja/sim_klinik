<?php

namespace App\Http\Requests\Admin\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateMasterPerawat extends FormRequest
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

        $id = $this->route('master_perawat');

        return [
            'poli_id' => 'required',
            'nama' => 'required|max:100|regex:/^[A-Za-z\s]+$/',
            'no_str' => ['max:20','regex:/^[A-Za-z0-9\s]+$/', Rule::unique('perawat','no_str')->ignore($id)],
            'no_sip' => ['max:50', Rule::unique('perawat','no_sip')->ignore($id)],
            'no_nira' => ['max:30', Rule::unique('perawat','no_nira')->ignore($id)],
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required|max:100|regex:/^[A-Za-z\s]+$/',
            'tgl_lahir' => 'required|before:today',
            'no_telp' => 'required|max:20|regex:/^[0-9]+$/',
            'email' => ['required','email:rfc,dns','max:100'],
            'alamat' => 'required|max:200',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // opsional: validasi foto
        ];
    }

    public function messages(){
        return [
            'poli_id.required' => 'Silahkan pilih Poli terlebih dahulu',

            'nama.required' => 'Nama tidak boleh kosong',
            'nama.max' => 'Nama maksimal 100 karakter',
            'nama.regex' =>'Nama hanya boleh mengandung huruf',

            'no_str.required' => 'No Surat Tanda Registrasi tidak boleh kosong',
            'no_str.max' => ' No Surat Tanda Registrasi maksimal 20 karakter',
            'no_str.regex' =>'No Surat Tanda Registrasi tidak boleh mengandung simbol',
            'no_str.unique' => ' No Surat Tanda Registrasi sudah terdaftar',

            'no_sip.max' => 'No Surat Izin Praktik maksimal 50 karakter',
            'no_sip.unique' => ' No Surat Izin Praktik sudah terdaftar',

            'no_nira.max' => 'No Induk Registrasi Anggota maksimal 30 karakter',
            'no_nira.unique' => ' No Induk Registrasi Anggota sudah terdaftar',

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

        ];
    }
}
