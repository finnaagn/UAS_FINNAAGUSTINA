<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['form', 'url']);
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/admin/dashboard');
        }

        return view('auth/login');
    }

    public function attemptLogin()
    {
        $username = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->getAdminByUsername($username);

        if (!$admin || $admin['status_aktif'] !== 'aktif') {
            return redirect()->back()->with('error', 'Username tidak ditemukan atau akun tidak aktif')->withInput();
        }

        if (!password_verify($password, $admin['password'])) {
            return redirect()->back()->with('error', 'Password salah')->withInput();
        }

        // Update last login
        $this->adminModel->updateLastLogin($admin['id_admin']);

        // Set session
        $sessionData = [
            'id_admin'    => $admin['id_admin'],
            'username'    => $admin['username'],
            'nama_lengkap' => $admin['nama_lengkap'],
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        return redirect()->to('/admin/dashboard');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}