<?php
namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table = 'dokter';
    protected $primaryKey = 'id_dokter';
    protected $allowedFields = ['nama_dokter', 'spesialisasi', 'jadwal_praktek', 'status_aktif'];
    protected $useTimestamps = false;

    // Validasi
    protected $validationRules = [
        'nama_dokter' => 'required|min_length[3]|max_length[100]',
        'spesialisasi' => 'required|max_length[50]',
        'status_aktif' => 'required|in_list[aktif,cuti,nonaktif]'
    ];

    protected $validationMessages = [
        'nama_dokter' => [
            'required' => 'Nama dokter wajib diisi',
            'min_length' => 'Nama dokter minimal 3 karakter'
        ],
        'spesialisasi' => [
            'required' => 'Spesialisasi wajib diisi'
        ]
    ];
}