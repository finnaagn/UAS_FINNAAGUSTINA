<?php
namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\RiwayatPendaftaranModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PendaftaranController extends BaseController
{
    protected $pendaftaranModel;
    protected $pasienModel;
    protected $dokterModel;
    protected $riwayatModel;

    public function __construct()
    {
        $this->pendaftaranModel = new PendaftaranModel();
        $this->pasienModel = new PasienModel();
        $this->dokterModel = new DokterModel();
        $this->riwayatModel = new RiwayatPendaftaranModel();
        helper(['form', 'date']);
    }

    // List semua pendaftaran
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Manajemen Pendaftaran',
            'pendaftaran' => $this->pendaftaranModel->getPendaftaranWithRelations()->findAll()
        ];

        return view('admin/pendaftaran/index', $data);
    }

    // Form tambah pendaftaran
    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Pendaftaran Baru',
            'pasien' => $this->pasienModel->findAll(),
            'dokter' => $this->dokterModel->where('status_aktif', 'aktif')->findAll()
        ];

        return view('admin/pendaftaran/create', $data);
    }

    // Simpan pendaftaran baru
    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (!$this->validate($this->pendaftaranModel->getValidationRules())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->pendaftaranModel->save([
            'id_pasien' => $this->request->getPost('id_pasien'),
            'id_dokter' => $this->request->getPost('id_dokter'),
            'keluhan' => $this->request->getPost('keluhan'),
            'tanggal_kunjungan' => $this->request->getPost('tanggal_kunjungan'),
            'jam_kunjungan' => $this->request->getPost('jam_kunjungan'),
            'status' => 'pending'
        ]);

        return redirect()->to('/admin/pendaftaran')
            ->with('message', 'Pendaftaran berhasil ditambahkan');
    }

    // Form edit pendaftaran
    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pendaftaran = $this->pendaftaranModel->find($id);
        if (!$pendaftaran) {
            throw new PageNotFoundException('Pendaftaran tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pendaftaran',
            'pendaftaran' => $pendaftaran,
            'pasien' => $this->pasienModel->findAll(),
            'dokter' => $this->dokterModel->findAll(),
            'riwayat' => $this->riwayatModel->getByPendaftaran($id)
        ];

        return view('admin/pendaftaran/edit', $data);
    }

    // Update pendaftaran
    public function update($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pendaftaran = $this->pendaftaranModel->find($id);
        if (!$pendaftaran) {
            throw new PageNotFoundException('Pendaftaran tidak ditemukan');
        }

        $rules = $this->pendaftaranModel->getValidationRules();
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $statusSebelumnya = $pendaftaran['status'];
        $statusBaru = $this->request->getPost('status');

        $data = [
            'id_pasien' => $this->request->getPost('id_pasien'),
            'id_dokter' => $this->request->getPost('id_dokter'),
            'keluhan' => $this->request->getPost('keluhan'),
            'tanggal_kunjungan' => $this->request->getPost('tanggal_kunjungan'),
            'jam_kunjungan' => $this->request->getPost('jam_kunjungan'),
            'status' => $statusBaru,
            'catatan_admin' => $this->request->getPost('catatan_admin')
        ];

        // Logika untuk membuat riwayat otomatis ketika status berubah dari pending
        if ($statusSebelumnya == 'pending' && $statusSebelumnya != $statusBaru) {
            $this->riwayatModel->catatPerubahan([
                'id_pendaftaran' => $id,
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => $statusBaru,
                'diubah_oleh' => session()->get('username') ?? 'System',
                'catatan_perubahan' => $this->request->getPost('catatan_admin') ?? 'Status berubah dari pending'
            ]);

            // Tambahkan tanggal diproses
            $data['tanggal_diproses'] = date('Y-m-d H:i:s');
        }
        // Catat juga perubahan status lainnya (non-pending)
        elseif ($statusSebelumnya != $statusBaru) {
            $this->riwayatModel->catatPerubahan([
                'id_pendaftaran' => $id,
                'status_sebelumnya' => $statusSebelumnya,
                'status_baru' => $statusBaru,
                'diubah_oleh' => session()->get('username') ?? 'System',
                'catatan_perubahan' => $this->request->getPost('catatan_admin') ?? 'Perubahan status'
            ]);
        }

        $this->pendaftaranModel->update($id, $data);

        return redirect()->to('/admin/pendaftaran')
            ->with('message', 'Pendaftaran berhasil diperbarui');
    }

    // Hapus pendaftaran
    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pendaftaran = $this->pendaftaranModel->find($id);
        if (!$pendaftaran) {
            throw new PageNotFoundException('Pendaftaran tidak ditemukan');
        }

        // Catat riwayat sebelum menghapus
        $this->riwayatModel->catatPerubahan([
            'id_pendaftaran' => $id,
            'status_sebelumnya' => $pendaftaran['status'],
            'status_baru' => 'dihapus',
            'diubah_oleh' => session()->get('username') ?? 'System',
            'catatan_perubahan' => 'Pendaftaran dihapus dari sistem'
        ]);

        $this->pendaftaranModel->delete($id);

        return redirect()->to('/admin/pendaftaran')
            ->with('message', 'Pendaftaran berhasil dihapus');
    }

    // Ubah status pendaftaran (AJAX)
    public function updateStatus($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }

        $pendaftaran = $this->pendaftaranModel->find($id);
        if (!$pendaftaran) {
            return $this->response->setJSON(['error' => 'Pendaftaran tidak ditemukan'])->setStatusCode(404);
        }

        $status = $this->request->getPost('status');
        $catatan = $this->request->getPost('catatan');

        $data = [
            'status' => $status,
            'catatan_admin' => $catatan,
            'tanggal_diproses' => date('Y-m-d H:i:s')
        ];

        // Catat riwayat perubahan
        $this->riwayatModel->catatPerubahan([
            'id_pendaftaran' => $id,
            'status_sebelumnya' => $pendaftaran['status'],
            'status_baru' => $status,
            'diubah_oleh' => session()->get('username') ?? 'System',
            'catatan_perubahan' => $catatan
        ]);

        if ($this->pendaftaranModel->update($id, $data)) {
            return $this->response->setJSON(['success' => true]);
        }

        return $this->response->setJSON(['error' => 'Gagal memperbarui status']);
    }

    // Lihat riwayat pendaftaran
    public function riwayat($id_pendaftaran)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pendaftaran = $this->pendaftaranModel->getPendaftaranWithRelations()
                        ->where('pendaftaran.id_pendaftaran', $id_pendaftaran)
                        ->first();

        if (!$pendaftaran) {
            throw new PageNotFoundException('Pendaftaran tidak ditemukan');
        }

        $data = [
            'title' => 'Riwayat Pendaftaran',
            'pendaftaran' => $pendaftaran,
            'riwayat' => $this->riwayatModel->getByPendaftaran($id_pendaftaran)
        ];

        return view('admin/pendaftaran/riwayat', $data);
    }
}