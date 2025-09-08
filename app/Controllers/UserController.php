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
        $data['users'] = (new \App\Models\UserModel())->where('role', 'customer')->findAll();
        $data['title'] = 'Users';
        $data['submenu_title'] = 'Penyewa';
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
}
