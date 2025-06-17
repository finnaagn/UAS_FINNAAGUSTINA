<?php

namespace App\Models;

use CodeIgniter\Model;

class PasienModel extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';
    protected $allowedFields = ['nik', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'no_telepon', 'email'];
    protected $useTimestamps = false;
    // Hapus callback hashPassword karena tidak diperlukan lagi

    // Validasi
    protected $validationRules = [
        'nik' => 'required|exact_length[16]|numeric|is_unique[pasien.nik,id_pasien,{id_pasien}]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'tanggal_lahir' => 'required|valid_date',
        'jenis_kelamin' => 'required|in_list[L,P]',
        'alamat' => 'required|min_length[5]',
        'no_telepon' => 'required|min_length[10]|max_length[15]|numeric',
        'email' => 'permit_empty|valid_email|max_length[100]'
    ];

    protected $validationMessages = [
        'nik' => [
            'is_unique' => 'NIK sudah terdaftar'
        ]
    ];

    // Hapus method hashPassword dan getPasienByNIK jika tidak digunakan lagi
}