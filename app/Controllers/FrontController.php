<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\MotorModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FrontController extends BaseController
{
    protected $MotorModel;
    protected $BrandModel;
    public function __construct()
    {
        $this->MotorModel = new MotorModel();
        $this->BrandModel = new BrandModel();
    }
    public function index()
    {
        $MotorModel = new MotorModel();
        $data = [
            'title' => 'Beranda',
            'motors' => $MotorModel
                ->select('motors.*, brands.brand as brand, types.type as type')
                ->join('brands', 'brands.id = motors.id_brand')
                ->join('types', 'types.id = motors.id_type')
                // ->asObject()
                ->findAll(),
            'brands' => $this->BrandModel->asObject()->findAll(),

        ];
        return view('frontend/home', $data);
    }

    public function produk()
    {
        $data = [
            'title' => 'Produk',
            'motors' => $this->MotorModel->findAll(),
            'brands' => $this->BrandModel->findAll(),
        ];
        return view('frontend/produk', $data);
    }

    public function tentang_kami()
    {
        $data = [
            'title' => 'Tentang Kami',
        ];
        return view('frontend/tentang-kami', $data);
    }
    public function faq()
    {
        $data = [
            'title' => 'FAQ',
        ];
        return view('frontend/faq', $data);
    }
    public function kontak()
    {
        $data = [
            'title' => 'Kontak',
        ];
        return view('frontend/kontak', $data);
    }
}
