<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BrandController extends BaseController
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
            'submenu_title' => 'Brand',
        ];
        return view('dashboard/brands-index', $data);
    }

    public function create()
    {
        return view('brands/create');
    }
}
