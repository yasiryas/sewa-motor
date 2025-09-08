<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class DashboardController extends BaseController
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
            'title' => 'Dashboard',
            'submenu_title' => '',
            'user' => (new \App\Models\UserModel())->find(session()->get('id')),
            'motors' => (new \App\Models\MotorModel())->countAllResults(),
            'bookings' => (new \App\Models\BookingModel())->countAllResults(),
            'customers' => (new \App\Models\UserModel())->where('role', 'customer')->countAllResults(),
        ];
        return view('dashboard/index', $data);
    }
}
