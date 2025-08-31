<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MotorController extends BaseController
{
    protected $motorModel;

    public function __construct()
    {
        $this->motorModel = new \App\Models\MotorModel();
    }
    public function index()
    {
        //
        $data['motors'] = $this->motorModel->findAll();
        return view('motors/index', $data);
    }

    public function view($id)
    {
        //
        $data['motor'] = $this->motorModel->find($id);
        if (!$data['motor']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Motor not found');
        }
        return view('motors/view', $data);
    }
}
