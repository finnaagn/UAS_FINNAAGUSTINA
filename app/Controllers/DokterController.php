<?php
namespace App\Controllers;

use App\Models\DokterModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DokterController extends BaseController
{
    protected $dokterModel;

    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        helper(['form']);
    }

    // List semua dokter
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Manajemen Dokter',
            'dokter' => $this->dokterModel->findAll()
        ];

        return view('admin/dokter/index', $data);
    }

    // Form tambah dokter
    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Dokter Baru'
        ];

        return view('admin/dokter/create', $data);
    }

    // Simpan dokter baru
    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (!$this->validate($this->dokterModel->getValidationRules())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->dokterModel->save([
            'nama_dokter' => $this->request->getPost('nama_dokter'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
            'jadwal_praktek' => $this->request->getPost('jadwal_praktek'),
            'status_aktif' => $this->request->getPost('status_aktif')
        ]);

        return redirect()->to('/admin/dokter')
            ->with('message', 'Dokter berhasil ditambahkan');
    }

    // Form edit dokter
    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $dokter = $this->dokterModel->find($id);
        if (!$dokter) {
            throw new PageNotFoundException('Dokter tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Dokter',
            'dokter' => $dokter
        ];

        return view('admin/dokter/edit', $data);
    }

    // Update dokter
    public function update($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $dokter = $this->dokterModel->find($id);
        if (!$dokter) {
            throw new PageNotFoundException('Dokter tidak ditemukan');
        }

        if (!$this->validate($this->dokterModel->getValidationRules())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $this->dokterModel->update($id, [
            'nama_dokter' => $this->request->getPost('nama_dokter'),
            'spesialisasi' => $this->request->getPost('spesialisasi'),
            'jadwal_praktek' => $this->request->getPost('jadwal_praktek'),
            'status_aktif' => $this->request->getPost('status_aktif')
        ]);

        return redirect()->to('/admin/dokter')
            ->with('message', 'Data dokter berhasil diperbarui');
    }

    // Hapus dokter
    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $dokter = $this->dokterModel->find($id);
        if (!$dokter) {
            throw new PageNotFoundException('Dokter tidak ditemukan');
        }

        $this->dokterModel->delete($id);

        return redirect()->to('/admin/dokter')
            ->with('message', 'Dokter berhasil dihapus');
    }
}