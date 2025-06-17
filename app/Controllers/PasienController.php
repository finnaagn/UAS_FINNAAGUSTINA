<?php

namespace App\Controllers;

use App\Models\PasienModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PasienController extends BaseController
{
    protected $pasienModel;

    public function __construct()
    {
        $this->pasienModel = new PasienModel();
        helper(['form', 'date']);
    }

    // List semua pasien
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Manajemen Pasien',
            'pasien' => $this->pasienModel->findAll()
        ];

        return view('admin/pasien/index', $data);
    }

    // Form tambah pasien
    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Pasien Baru'
        ];

        return view('admin/pasien/create', $data);
    }

    // Simpan pasien baru (tanpa password)
    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rules = $this->pasienModel->getValidationRules();

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nik' => $this->request->getPost('nik'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email')
        ];

        $this->pasienModel->insert($data);

        return redirect()->to('/admin/pasien')->with('message', 'Pasien berhasil ditambahkan');
    }

    // Form edit pasien
    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pasien = $this->pasienModel->find($id);

        if (!$pasien) {
            throw new PageNotFoundException('Pasien tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Data Pasien',
            'pasien' => $pasien
        ];

        return view('admin/pasien/edit', $data);
    }

    // Update pasien (tanpa password)
    public function update($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pasien = $this->pasienModel->find($id);
        if (!$pasien) {
            throw new PageNotFoundException('Pasien tidak ditemukan');
        }

        $rules = $this->pasienModel->getValidationRules();
        $rules['nik'] = 'required|exact_length[16]|numeric';

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'tanggal_lahir' => $this->request->getPost('tanggal_lahir'),
            'jenis_kelamin' => $this->request->getPost('jenis_kelamin'),
            'alamat' => $this->request->getPost('alamat'),
            'no_telepon' => $this->request->getPost('no_telepon'),
            'email' => $this->request->getPost('email')
        ];

        if (!$this->pasienModel->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->pasienModel->errors());
        }

        return redirect()->to(base_url('admin/pasien'))->with('message', 'Data pasien berhasil diperbarui');
    }

    // Hapus pasien
    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $pasien = $this->pasienModel->find($id);

        if (!$pasien) {
            throw new PageNotFoundException('Pasien tidak ditemukan');
        }

        $this->pasienModel->delete($id);

        return redirect()->to('/admin/pasien')->with('message', 'Pasien berhasil dihapus');
    }
}