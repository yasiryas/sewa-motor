<?php

namespace App\Controllers;

use App\Models\TypeModel;
use App\Models\BrandModel;
use App\Models\MotorModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class MotorController extends BaseController
{
    protected $MotorModel;
    protected $TypeModel;
    protected $BrandModel;

    public function __construct()
    {
        $this->MotorModel = new MotorModel();
        $this->BrandModel = new BrandModel();
        $this->TypeModel = new TypeModel();
    }

    public function index()
    {
        //
        $brands = $this->BrandModel->asObject()->findAll();
        $types = $this->TypeModel->asObject()->findAll();
        $motors = $this->MotorModel
            ->select('motors.*, brands.brand as brand, types.type as type')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('types', 'types.id = motors.id_type')
            ->asObject()
            ->findAll();
        $data = [
            'title' => 'Inventaris',
            'submenu_title' =>
            'Motor',
            'motors' => $motors,
            'brands' => $brands,
            'types' => $types
        ];
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

    public function store()
    {
        $validationRules = [
            'name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama motor harus diisi.',
                    'min_length' => 'Nama motor minimal 3 karakter.'
                ]
            ],
            'number_plate' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'No Plat motor harus diisi.',
                    'min_length' => 'No Plat motor minimal 3 karakter.'
                ]
            ],
            'id_brand' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Brand harus dipilih.',
                    'integer'  => 'Brand tidak valid.'
                ]
            ],
            'id_type' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Type harus dipilih.',
                    'integer'  => 'Type tidak valid.'
                ]
            ],
            'price_per_day' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Harga per hari harus diisi.',
                    'decimal'  => 'Harga per hari harus angka.'
                ]
            ],
            'availability_status' => [
                'rules' => 'required|in_list[available,unavailable]',
                'errors' => [
                    'required' => 'Status harus dipilih.',
                    'in_list'  => 'Status tidak valid.'
                ]
            ],
            'description' => [
                'rules' => 'permit_empty|string',
                'errors' => [
                    'string' => 'Deskripsi harus berupa teks.'
                ]
            ],
            'photo' => [
                'rules' => 'if_exist|uploaded[photo]|is_image[photo]|max_size[photo,2048]',
                'errors' => [
                    'uploaded' => 'Foto harus diupload.',
                    'is_image' => 'File harus berupa gambar.',
                    'max_size' => 'Ukuran foto maksimal 2MB.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to('dashboard/inventaris/motor')
                ->withInput()
                ->with('error', $this->validator->listErrors())
                ->with('modal', 'addMotorModal');
        }

        // handle upload foto
        $photoFile = $this->request->getFile('photo');
        $photoName = null;

        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            $photoName = $photoFile->getRandomName();
            $photoFile->move(FCPATH . 'uploads/motors', $photoName);
        }

        // simpan ke DB
        $this->MotorModel->insert([
            'name'                => $this->request->getPost('name'),
            'number_plate'        => $this->request->getPost('number_plate'),
            'id_brand'            => $this->request->getPost('id_brand'),
            'id_type'             => $this->request->getPost('id_type'),
            'price_per_day'       => $this->request->getPost('price_per_day'),
            'availability_status' => $this->request->getPost('availability_status'),
            'description'         => $this->request->getPost('description'),
            'photo'               => $photoName,
        ]);

        session()->setFlashdata('success', 'Motor berhasil ditambahkan.');
        return redirect()->to('dashboard/inventaris/motor');
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        $motor = $this->MotorModel->find($id);
        if (!$motor) {
            return redirect()->to('dashboard/inventaris/motor')->with('error', 'Motor tidak ditemukan.');
        }

        // hapus foto lama jika ada
        if ($motor['photo']) {
            $oldPhotoPath = FCPATH . 'uploads/motors/' . $motor['photo'];
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        // hapus data motor
        $this->MotorModel->delete($id);
        session()->setFlashdata('success', 'Motor berhasil dihapus.');
        return redirect()->to('dashboard/inventaris/motor');
    }

    public function update()
    {
        $id = $this->request->getPost('update_id_motor');
        $motor = $this->MotorModel->find($id);
        if (!$motor) {
            return redirect()->to('dashboard/inventaris/motor')->with('error', 'Motor tidak ditemukan.');
        }

        $validationRules = [
            'update_name_motor' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'Nama motor harus diisi.',
                    'min_length' => 'Nama motor minimal 3 karakter.'
                ]
            ],
            'update_plate_motor' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required'   => 'No Plat motor harus diisi.',
                    'min_length' => 'No Plat motor minimal 3 karakter.'
                ]
            ],
            'update_id_brand' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Brand harus dipilih.',
                    'integer'  => 'Brand tidak valid.'
                ]
            ],
            'id_type_update' => [
                'rules' => 'required|integer',
                'errors' => [
                    'required' => 'Type harus dipilih.',
                    'integer'  => 'Type tidak valid.'
                ]
            ],
            'price_per_day_update' => [
                'rules' => 'required|decimal',
                'errors' => [
                    'required' => 'Harga per hari harus diisi.',
                    'decimal'  => 'Harga per hari harus angka.'
                ]
            ],
            'availability_status_update' => [
                'rules' => 'required|in_list[available,rented,maintenance]',
                'errors' => [
                    'required' => 'Status harus dipilih.',
                    'in_list'  => 'Status tidak valid.'
                ]
            ],
            'description_update' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Deskripsi harus diisi.'
                ]
            ],
            'photo_update' => [
                'rules' => 'if_exist|is_image[photo_update]|max_size[photo,2048]',
                'errors' => [
                    'is_image' => 'File harus berupa gambar.',
                    'max_size' => 'Ukuran foto maksimal 2MB.'
                ]
            ]
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->to('dashboard/inventaris/motor')
                ->withInput()
                ->with('error', $this->validator->listErrors())
                ->with('modal', 'editMotorModal');
        }

        // handle upload foto
        $photoFile = $this->request->getFile('photo_update');
        $photoName = null;

        if ($photoFile && $photoFile->isValid() && !$photoFile->hasMoved()) {
            $photoName = $photoFile->getRandomName();
            $photoFile->move(FCPATH . 'uploads/motors', $photoName);
        }

        // update data motor
        $this->MotorModel->update($id, [
            'name'                => $this->request->getPost('update_name_motor'),
            'number_plate'        => $this->request->getPost('update_plate_motor'),
            'id_brand'            => $this->request->getPost('update_id_brand'),
            'id_type'             => $this->request->getPost('id_type_update'),
            'price_per_day'       => $this->request->getPost('price_per_day_update'),
            'availability_status' => $this->request->getPost('availability_status_update'),
            'description'         => $this->request->getPost('description_update'),
            'photo'               => $photoName ?? $motor['photo'],
        ]);

        session()->setFlashdata('success', 'Motor berhasil diperbarui.');
        return redirect()->to('dashboard/inventaris/motor');
    }
}
