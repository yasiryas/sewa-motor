<?php

namespace App\Controllers;

use App\Models\MotorModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MotorController extends BaseController
{
    protected $MotorModel;

    public function __construct()
    {
        $this->MotorModel = new MotorModel();
    }

    public function index()
    {
        //
        $data = ['title' => 'Inventaris', 'submenu_title' => 'Motor', 'Motor' => $this->MotorModel->getAvailableMotors()];
        return view('dashboard/motor-index', $data);
    }

    public function show($id)
    {
        //
        $motor = $this->MotorModel->find($id);
        if (!$motor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Motor not found');
        }
        return view('motors/show', ['motor' => $motor]);
    }

    public function view($id)
    {
        //
        $data['motor'] = $this->MotorModel->find($id);
        if (!$data['motor']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Motor not found');
        }
        return view('motors/view', $data);
    }

    public function list()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }
        $data['motors'] = $this->MotorModel->findAll();
        $data['title'] = 'Inventaris';
        $data['submenu_title'] = 'Motor';
        return view('dashboard/motor', $data);
    }

    public function reportMotors()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }
        $data['motors'] = $this->MotorModel->findAll();
        $data['title'] = 'Report';
        $data['submenu_title'] = 'Report Motor';
        return view('dashboard/motor-report', $data);
    }
}
