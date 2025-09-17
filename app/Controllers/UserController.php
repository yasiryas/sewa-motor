<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function index() {}
    public function dashboard()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $userModel = new \App\Models\UserModel();
        $data = [
            'title' => 'Users',
            'submenu_title' => 'Penyewa',
            'user' => $userModel->find(session()->get('id')),
            'users' => $userModel->where('role', 'user')->findAll(),
        ];
        return view('dashboard/users', $data);
    }

    public function reportUsers()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }
        $data['users'] = (new \App\Models\UserModel())->where('role', 'customer')->findAll();
        $data['title'] = 'Report';
        $data['submenu_title'] = 'Report Users';
        return view('dashboard/user-report', $data);
    }

    public function store()
    {
        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'username' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role' => 'required|in_list[admin,user]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $userData = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getPost('role'),
        ];

        $userModel->insert($userData);
        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }
}
