<?php
namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan_pendaftaran';
    protected $primaryKey = 'id_laporan';
    protected $allowedFields = [
        'jenis_laporan', 'periode_mulai', 'periode_selesai',
        'total_pendaftar', 'total_disetujui', 'total_ditolak', 'total_dibatalkan',
        'generated_by'
    ];
    protected $useTimestamps = false;

    // Generate laporan
    public function generateLaporan($data)
    {
        return $this->insert([
            'jenis_laporan' => $data['jenis_laporan'],
            'periode_mulai' => $data['periode_mulai'],
            'periode_selesai' => $data['periode_selesai'],
            'total_pendaftar' => $data['total_pendaftar'],
            'total_disetujui' => $data['total_disetujui'],
            'total_ditolak' => $data['total_ditolak'],
            'total_dibatalkan' => $data['total_dibatalkan'],
            'generated_by' => $data['generated_by']
        ]);
    }

    // Get laporan dengan nama admin
public function getLaporanWithAdmin()
{
    return $this->select('laporan_pendaftaran.*, admin.nama_lengkap as nama_admin')
               ->join('admin', 'admin.id_admin = laporan_pendaftaran.generated_by')
               ->orderBy('tanggal_generate', 'DESC');
}


}