<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminController extends BaseController
{
    protected $adminModel;
    protected $middleware;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->middleware = \Config\Services::middleware();
        helper(['form', 'url', 'text']);
    }

    // Method untuk dashboard (dari controller lama)
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Dashboard Admin',
            'nama_lengkap' => session()->get('nama_lengkap'),
        ];

        return view('admin/dashboard', $data);
    }

    // Method untuk manajemen pengguna (dari controller baru)
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Manajemen Pengguna',
            'admins' => $this->adminModel->findAll()
        ];

        return view('admin/pengguna/index', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Tambah Pengguna Baru'
        ];

        return view('admin/pengguna/create', $data);
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $rules = [
            'username' => 'required|min_length[5]|max_length[50]|is_unique[admin.username]',
            'password' => 'required|min_length[8]',
            'password_confirm' => 'matches[password]',
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'status_aktif' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'status_aktif' => $this->request->getPost('status_aktif')
        ];

        $this->adminModel->insert($data);

        return redirect()->to('/admin/pengguna')->with('message', 'Pengguna berhasil ditambahkan');
    }

    public function edit($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $admin = $this->adminModel->find($id);

        if (!$admin) {
            throw new PageNotFoundException('Pengguna tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Pengguna',
            'admin' => $admin
        ];

        return view('admin/pengguna/edit', $data);
    }

    public function update($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $admin = $this->adminModel->find($id);

        if (!$admin) {
            throw new PageNotFoundException('Pengguna tidak ditemukan');
        }

        $rules = [
            'username' => "required|min_length[5]|max_length[50]|is_unique[admin.username,id_admin,{$id}]",
            'nama_lengkap' => 'required|min_length[3]|max_length[100]',
            'status_aktif' => 'required'
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'status_aktif' => $this->request->getPost('status_aktif')
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->adminModel->update($id, $data);

        return redirect()->to('/admin/pengguna')->with('message', 'Pengguna berhasil diperbarui');
    }

    public function delete($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $admin = $this->adminModel->find($id);

        if (!$admin) {
            throw new PageNotFoundException('Pengguna tidak ditemukan');
        }

        if ($admin['id_admin'] == session()->get('id_admin')) {
            return redirect()->to('/admin/pengguna')->with('error', 'Anda tidak dapat menghapus akun sendiri');
        }

        $this->adminModel->delete($id);

        return redirect()->to('/admin/pengguna')->with('message', 'Pengguna berhasil dihapus');
    }
}