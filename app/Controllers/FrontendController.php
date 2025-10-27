<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FrontendController extends BaseController
{
    protected $MotorModel;
    public function __construct()
    {
        $this->MotorModel = new \App\Models\MotorModel();
    }
    public function index()
    {
        $motors = $this->MotorModel->getAvailableMotors();
        return view('frontend/home', ['motors' => $motors]);
    }

    public function produk()
    {
        $motors = $this->MotorModel->getAvailableMotors();
        // return view('frontend/produk', ['motors' => $motors]);
    }

    public function kategori()
    {
        $motors = $this->MotorModel->getAvailableMotors();
        return view('frontend/kategori', ['motors' => $motors]);
    }
}
