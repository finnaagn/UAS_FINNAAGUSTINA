<?php
namespace App\Models;

use CodeIgniter\Model;

class RiwayatPendaftaranModel extends Model
{
    protected $table = 'riwayat_pendaftaran';
    protected $primaryKey = 'id_riwayat';
    protected $allowedFields = [
        'id_pendaftaran', 'status_sebelumnya', 'status_baru',
        'diubah_oleh', 'catatan_perubahan'
    ];
    protected $useTimestamps = false;

    // Validasi
    protected $validationRules = [
        'id_pendaftaran' => 'required|numeric',
        'status_baru' => 'required|in_list[pending,disetujui,ditolak,dibatalkan]',
        'diubah_oleh' => 'required|max_length[50]'
    ];

    // Get riwayat by pendaftaran
    public function getByPendaftaran($id_pendaftaran)
    {
        return $this->where('id_pendaftaran', $id_pendaftaran)
                   ->orderBy('timestamp_perubahan', 'DESC')
                   ->findAll();
    }

    // Catat perubahan status
    public function catatPerubahan($data)
    {
        return $this->insert([
            'id_pendaftaran' => $data['id_pendaftaran'],
            'status_sebelumnya' => $data['status_sebelumnya'],
            'status_baru' => $data['status_baru'],
            'diubah_oleh' => $data['diubah_oleh'],
            'catatan_perubahan' => $data['catatan_perubahan'] ?? null,
            'timestamp_perubahan' => date('Y-m-d H:i:s') // tambahkan timestamp
        ]);
    }
}