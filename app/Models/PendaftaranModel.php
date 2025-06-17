<?php
namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table = 'pendaftaran';
    protected $primaryKey = 'id_pendaftaran';
    protected $allowedFields = [
        'id_pasien', 'id_dokter', 'keluhan', 'tanggal_kunjungan', 
        'jam_kunjungan', 'status', 'catatan_admin', 'tanggal_diproses'
    ];
    protected $useTimestamps = false;

    // Validasi
    protected $validationRules = [
        'id_dokter' => 'required|numeric',
        'keluhan' => 'required|min_length[10]',
        'tanggal_kunjungan' => 'required|valid_date',
        'jam_kunjungan' => 'required',
        'status' => 'permit_empty|in_list[pending,disetujui,ditolak,dibatalkan]'
    ];

    protected $validationMessages = [
        'id_pasien' => ['required' => 'Pasien harus dipilih'],
        'id_dokter' => ['required' => 'Dokter harus dipilih'],
        'keluhan' => [
            'required' => 'Keluhan harus diisi',
            'min_length' => 'Keluhan minimal 10 karakter'
        ]
    ];

    // Join dengan tabel pasien dan dokter
    public function getPendaftaranWithRelations()
    {
        return $this->select('pendaftaran.*, pasien.nama_lengkap as nama_pasien, pasien.nik, dokter.nama_dokter, dokter.spesialisasi')
                ->join('pasien', 'pasien.id_pasien = pendaftaran.id_pasien')
                ->join('dokter', 'dokter.id_dokter = pendaftaran.id_dokter');
    }
}