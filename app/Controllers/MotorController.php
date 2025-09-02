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
        $motors = $this->MotorModel->getAvailableMotors();
        return view('motors/index', ['motors' => $motors]);
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
}
