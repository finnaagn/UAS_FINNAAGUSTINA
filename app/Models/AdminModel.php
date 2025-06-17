<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $allowedFields = ['username', 'password', 'nama_lengkap', 'terakhir_login', 'status_aktif'];
    protected $useTimestamps = false;

    // Validasi untuk create dan update
    protected $validationRules = [
        'username' => 'required|min_length[5]|max_length[50]|is_unique[admin.username,id_admin,{id_admin}]',
        'nama_lengkap' => 'required|min_length[3]|max_length[100]',
        'status_aktif' => 'required|in_list[aktif,nonaktif]'
    ];

    protected $validationMessages = [
        'username' => [
            'is_unique' => 'Username sudah digunakan oleh admin lain'
        ]
    ];

    public function getAdminByUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function updateLastLogin($id_admin)
    {
        return $this->update($id_admin, ['terakhir_login' => date('Y-m-d H:i:s')]);
    }
}