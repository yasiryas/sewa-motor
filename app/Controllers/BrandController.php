<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class BrandController extends BaseController
{
    protected $brandModel;
    public function __construct()
    {
        $this->brandModel = new \App\Models\BrandModel();
    }
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
            'brands' => $this->brandModel->findAll(),
        ];
        // dd($data);
        return view('dashboard/brands-index', $data);
    }


    public function list()
    {
        $brands = $this->brandModel->findAll();
        return $this->response->setJSON($brands);
    }

    public function store()
    {
        // validasi
        // $name = $this->request->getPost('name');
        // $image = $this->request->getPost('image');
        // $nameExists = $this->brandModel->where('brand', $name)->first();
        // if (!$name) {
        //     return redirect()->to('dashboard/inventaris/brand')->withInput()->with('error', 'Nama brand harus diisi.')->with('modal', 'addBrandModal');
        // } else if ($nameExists && $name == $nameExists['brand']) {
        //     return redirect()->to('dashboard/inventaris/brand')->withInput()->with('error', 'Nama brand sudah ada.')->with('modal', 'addBrandModal');
        // }

        // if ($image == null) {
        //     $featured_image = 'brand_default.png';
        // }

        // $this->brandModel->insert([
        //     'brand' => $name,
        //     'featured_image' => $featured_image,
        // ]);
        // session()->setFlashdata('success', 'Brand berhasil ditambahkan.');
        // return redirect()->to('dashboard/inventaris/brand');


        $name = $this->request->getPost('name');
        $image = $this->request->getFile('image');

        // Cek nama brand
        $nameExists = $this->brandModel->where('brand', $name)->first();

        if (!$name) {
            return redirect()->to('dashboard/inventaris/brand')
                ->withInput()
                ->with('error', 'Nama brand harus diisi.')
                ->with('modal', 'addBrandModal');
        } elseif ($nameExists) {
            return redirect()->to('dashboard/inventaris/brand')
                ->withInput()
                ->with('error', 'Nama brand sudah ada.')
                ->with('modal', 'addBrandModal');
        }

        // Default image
        $featured_image = 'brand_default.png';

        // Jika ada file diupload
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/brand/', $newName);
            $featured_image = $newName;
        }

        // Simpan ke database
        $this->brandModel->insert([
            'brand' => $name,
            'featured_image' => $featured_image,
        ]);

        session()->setFlashdata('success', 'Brand berhasil ditambahkan.');
        return redirect()->to('dashboard/inventaris/brand');
    }

    public function edit($id)
    {
        $brand = $this->brandModel->find($id);
        if (!$brand) {
            return redirect()->to('dashboard/inventaris/brand')->with('error', 'Brand tidak ditemukan.');
        }
        return view('brands/edit', ['brand' => $brand]);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $brand = $this->brandModel->find($id);
        $image = $this->request->getPost('image');
        $nameExists = $this->brandModel->where('brand', $this->request->getPost('name'))->first();
        if (!$brand) {
            return redirect()->to('dashboard/inventaris/brand')->with('error', 'Brand tidak ditemukan.');
        }
        if (!$this->request->getPost('name')) {
            return redirect()->to('dashboard/inventaris/brand')->withInput()->with('error', 'Nama brand harus diisi.')->with('modal', 'addBrandModal');
        }
        if ($nameExists && $this->request->getPost('name') == $nameExists['brand']) {
            return redirect()->to('dashboard/inventaris/brand')->withInput()->with('error', 'Nama brand sudah ada.')->with('modal', 'updateBrandModal');
        }

        $this->brandModel->update($id, [
            'brand' => $this->request->getPost('name'),
            'featured_image' => $this->request->getPost('image'),
        ]);
        session()->setFlashdata('success', 'Brand berhasil diupdate.');
        return redirect()->to('dashboard/inventaris/brand');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $brand = $this->brandModel->find($id);
        if (!$brand) {
            return redirect()->to('dashboard/inventaris/brand')->with('error', 'Brand tidak ditemukan.');
        }
        $this->brandModel->delete($id);
        session()->setFlashdata('success', 'Brand berhasil dihapus.');
        return redirect()->to('dashboard/inventaris/brand');
    }
}
