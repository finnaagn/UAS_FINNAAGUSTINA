<?php
namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\PendaftaranModel;
use App\Models\DokterModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class BookingController extends BaseController
{
    protected $pasienModel;
    protected $pendaftaranModel;
    protected $dokterModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        $this->pendaftaranModel = new PendaftaranModel();
        $this->dokterModel = new DokterModel();
        helper(['form', 'date']);
    }

    // Halaman utama dengan pilihan
    public function index()
    {
        $data = [
            'title' => 'Sistem Pendaftaran Online'
        ];
        return view('public/booking_home', $data);
    }

    // Form pendaftaran baru
    public function newRegistration()
    {
        $data = [
            'title' => 'Pendaftaran Online',
            'dokter' => $this->dokterModel->where('status_aktif', 'aktif')->findAll()
        ];
        return view('public/booking_form', $data);
    }

    // Form pencarian booking
    public function searchBooking()
    {
        $data = [
            'title' => 'Cari Data Pendaftaran'
        ];
        return view('public/booking_search', $data);
    }

    // Proses pencarian booking
    public function processSearch()
    {
        $nik = $this->request->getPost('nik');
        $noTelepon = $this->request->getPost('no_telepon');
        
        // Validasi input
        if (empty($nik)) {
            return redirect()->back()->with('error', 'NIK harus diisi');
        }
        
        // Cari pasien berdasarkan NIK
        $pasien = $this->pasienModel->where('nik', $nik)->first();
        
        if (!$pasien) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan');
        }
        
        // Verifikasi nomor telepon jika diisi
        if (!empty($noTelepon) && $pasien['no_telepon'] != $noTelepon) {
            return redirect()->back()->with('error', 'Nomor telepon tidak sesuai');
        }
        
        // Cari semua pendaftaran pasien dengan data default jika tidak ada
        $pendaftaran = $this->pendaftaranModel->getPendaftaranWithRelations()
                        ->where('pasien.nik', $nik)
                        ->orderBy('pendaftaran.tanggal_kunjungan', 'DESC')
                        ->findAll();

        // Pastikan setiap pendaftaran memiliki key yang diperlukan
        foreach ($pendaftaran as &$item) {
            $item['status'] = $item['status'] ?? 'pending';
            // Tambahkan key lain jika diperlukan
        }
        
        $data = [
            'title' => 'Hasil Pencarian',
            'pendaftaran' => $pendaftaran,
            'pasien' => $pasien
        ];
        
        return view('public/booking_search_result', $data);
    }

    // Proses pendaftaran
    public function processRegistration()
    {
        // Validasi data pasien saja terlebih dahulu
        $pasienRules = $this->pasienModel->getValidationRules();
        
        if (!$this->validate($pasienRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Cek apakah pasien sudah ada berdasarkan NIK
        $pasien = $this->pasienModel->where('nik', $this->request->getPost('nik'))->first();

        // Jika pasien belum ada, buat baru
        if (!$pasien) {
            $pasienData = [
                'nik' => $this->request->getPost('nik'),
                'nama_lengkap' => $this->request->getPost('nama_lengkap'),
                'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
                'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
                'alamat' => $this->request->getPost('alamat'),
                'no_telepon' => $this->request->getPost('no_telepon'),
                'email' => $this->request->getPost('email')
            ];

            $pasienId = $this->pasienModel->insert($pasienData);
        } else {
            $pasienId = $pasien['id_pasien'];
        }

        // Sekarang validasi data pendaftaran setelah mendapatkan id_pasien
        $pendaftaranRules = [
            'id_dokter' => 'required|numeric',
            'keluhan' => 'required|min_length[10]',
            'tanggal_kunjungan' => 'required|valid_date',
            'jam_kunjungan' => 'required'
        ];
        
        if (!$this->validate($pendaftaranRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Simpan data pendaftaran
        $pendaftaranData = [
            'id_pasien' => $pasienId,
            'id_dokter' => $this->request->getPost('id_dokter'),
            'keluhan' => $this->request->getPost('keluhan'),
            'tanggal_kunjungan' => $this->request->getPost('tanggal_kunjungan'),
            'jam_kunjungan' => $this->request->getPost('jam_kunjungan'),
            'status' => 'pending' // Default status
        ];

        $pendaftaranId = $this->pendaftaranModel->insert($pendaftaranData);

        // Redirect dengan pesan sukses
        return redirect()->to('/booking/success/'.$pendaftaranId)
            ->with('message', 'Pendaftaran berhasil! Nomor pendaftaran Anda: '.$pendaftaranId);
    }

    // Halaman sukses
    public function registrationSuccess($id_pendaftaran)
    {
        $pendaftaran = $this->pendaftaranModel->getPendaftaranWithRelations()
                        ->where('pendaftaran.id_pendaftaran', $id_pendaftaran)
                        ->first();

        if (!$pendaftaran) {
            throw new PageNotFoundException('Data pendaftaran tidak ditemukan');
        }

        $data = [
            'title' => 'Pendaftaran Berhasil',
            'pendaftaran' => $pendaftaran
        ];

        return view('public/registration_success', $data);
    }

public function existingPatientRegistration()
{
    $data = [
        'title' => 'Pendaftaran Pasien Terdaftar',
        'dokter' => $this->dokterModel->where('status_aktif', 'aktif')->findAll()
    ];
    return view('public/booking_existing_form', $data);
}

public function processExistingRegistration()
{
    // Validasi input NIK dan nomor telepon
    $rules = [
        'nik' => 'required|exact_length[16]|numeric',
        'no_telepon' => 'required|min_length[10]|max_length[15]|numeric'
    ];
    
    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // Cek pasien
    $nik = $this->request->getPost('nik');
    $noTelepon = $this->request->getPost('no_telepon');
    
    $pasien = $this->pasienModel->where('nik', $nik)->first();
    
    if (!$pasien) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Pasien tidak ditemukan. Silakan lakukan pendaftaran baru.');
    }
    
    if ($pasien['no_telepon'] != $noTelepon) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Nomor telepon tidak sesuai dengan data kami.');
    }

    // Validasi data pendaftaran
    $pendaftaranRules = [
        'id_dokter' => 'required|numeric',
        'keluhan' => 'required|min_length[10]',
        'tanggal_kunjungan' => 'required|valid_date',
        'jam_kunjungan' => 'required'
    ];
    
    if (!$this->validate($pendaftaranRules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    // Simpan pendaftaran
    $pendaftaranData = [
        'id_pasien' => $pasien['id_pasien'],
        'id_dokter' => $this->request->getPost('id_dokter'),
        'keluhan' => $this->request->getPost('keluhan'),
        'tanggal_kunjungan' => $this->request->getPost('tanggal_kunjungan'),
        'jam_kunjungan' => $this->request->getPost('jam_kunjungan'),
        'status' => 'pending'
    ];

    $pendaftaranId = $this->pendaftaranModel->insert($pendaftaranData);

    return redirect()->to('/booking/success/'.$pendaftaranId)
        ->with('message', 'Pendaftaran berhasil! Nomor pendaftaran Anda: '.$pendaftaranId);
}
}