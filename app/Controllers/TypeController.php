<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TypeController extends BaseController
{
    public function index()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Inventaris',
            'submenu_title' => 'Type'
        ];

        return view('dashboard/type-index', $data);
    }

    public function create()
    {
        return view('types/create');
    }
}
