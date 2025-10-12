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
        $featured_image = 'default_brand.jpg';

        // Jika ada file diupload dan valid
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move(FCPATH . 'uploads/brands', $newName); // pastikan path absolut
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

        if (!$brand) {
            return redirect()->to('dashboard/inventaris/brand')->with('error', 'Brand tidak ditemukan.');
        }

        $name = $this->request->getPost('name');
        $image = $this->request->getFile('image');

        // Validasi nama kosong
        if (!$name) {
            return redirect()->to('dashboard/inventaris/brand')
                ->withInput()
                ->with('error', 'Nama brand harus diisi.')
                ->with('modal', 'updateBrandModal');
        }

        // Cek nama duplikat tapi abaikan brand sendiri
        $nameExists = $this->brandModel
            ->where('brand', $name)
            ->where('id !=', $id)
            ->first();

        if ($nameExists) {
            return redirect()->to('dashboard/inventaris/brand')
                ->withInput()
                ->with('error', 'Nama brand sudah ada.')
                ->with('modal', 'updateBrandModal');
        }

        // Default: pakai gambar lama
        $featured_image = $brand['featured_image'];

        // Jika upload gambar baru
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/brands/', $newName);

            // Hapus file lama jika bukan default
            if ($featured_image !== 'default_brand.jpg' && file_exists('uploads/brands/' . $featured_image)) {
                unlink('uploads/brands/' . $featured_image);
            }

            $featured_image = $newName;
        }

        // Simpan perubahan
        $this->brandModel->update($id, [
            'brand' => $name,
            'featured_image' => $featured_image,
        ]);

        session()->setFlashdata('success', 'Brand berhasil diperbarui.');
        return redirect()->to('dashboard/inventaris/brand');
    }


    public function delete()
    {
        $id = $this->request->getPost('id');
        $brand = $this->brandModel->find($id);

        if (!$brand) {
            return redirect()->to('dashboard/inventaris/brand')
                ->with('error', 'Brand tidak ditemukan.');
        }

        // Hapus gambar jika bukan default
        if (!empty($brand['featured_image']) && $brand['featured_image'] !== 'default_brand.jpg') {
            $imagePath = FCPATH . 'uploads/brands/' . $brand['featured_image'];

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Hapus data di database
        $this->brandModel->delete($id);

        session()->setFlashdata('success', 'Brand berhasil dihapus.');
        return redirect()->to('dashboard/inventaris/brand');
    }
}
