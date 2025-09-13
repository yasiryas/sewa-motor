<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TypeController extends BaseController
{
    protected $typeModel;

    public function __construct()
    {
        $this->typeModel = new \App\Models\TypeModel();
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
            'submenu_title' => 'Type',
            'types' =>  $this->typeModel->findAll(),
        ];

        return view('dashboard/type-index', $data);
    }

    public function store()
    {
        // validasi
        $rules = [
            'name' => [
                'rules' => 'required|is_unique[types.type]',
                'errors' => [
                    'required' => 'Nama type harus diisi.',
                    'is_unique' => 'Nama type sudah ada.',
                ],
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('dashboard/inventaris/type')->withInput()->with('error', $this->validator->getError('name'))->with('modal', 'addTypeModal');
        }

        $this->typeModel->insert([
            'type' => $this->request->getPost('name'),
        ]);

        session()->setFlashdata('success', 'Type berhasil ditambahkan.');
        return redirect()->to('dashboard/inventaris/type');
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');

        $type = $this->typeModel->find($id);
        if (!$type) {
            return redirect()->to('dashboard/inventaris/type')->with('error', 'Type tidak ditemukan.');
        }

        // validasi
        $rules = [
            'name' => [
                'rules' => 'required|is_unique[types.type]',
                'errors' => [
                    'required' => 'Nama type harus diisi.',
                    'is_unique' => 'Nama type sudah ada.',
                ],
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('dashboard/inventaris/type')->withInput()->with('error', $this->validator->getError('name'))->with('modal', 'editTypeModal');
        }

        $this->typeModel->update($id, [
            'type' => $name,
        ]);

        session()->setFlashdata('success', 'Type berhasil diupdate.');
        return redirect()->to('dashboard/inventaris/type');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $type = $this->typeModel->find($id);
        if (!$type) {
            return redirect()->to('dashboard/inventaris/type')->with('error', 'Type tidak ditemukan.');
        }
        $this->typeModel->delete($id);
        session()->setFlashdata('success', 'Type berhasil dihapus.');
        return redirect()->to('dashboard/inventaris/type');
    }
}
