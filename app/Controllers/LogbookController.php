<?php

namespace App\Controllers;

use App\Models\MotorLogbookModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\BookingModel;
use App\Models\MotorModel;



class LogbookController extends BaseController
{
    protected $MotorLogbook;
    protected $UserModel;
    protected $MotorModel;
    protected $BookingModel;
    public function __construct()
    {
        $this->MotorLogbook = new MotorLogbookModel();
        $this->UserModel = new UserModel();
        $this->MotorModel = new MotorModel();
        $this->BookingModel = new BookingModel();
    }

    public function index()
    {
        $type = $this->request->getGet('type');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        $builder = $this->MotorLogbook;
        if ($type && in_array($type, ['check-in', 'check-out'])) {
            $builder->where('type', $type);
        }
        if ($startDate && $endDate) {
            $builder->where('DATE(motor_logbooks.created_at) >=', $startDate)
                ->where('DATE(motor_logbooks.created_at) <=', $endDate);
        }

        $motors = $this->MotorModel->findAll();
        $bookings = $this->BookingModel
            ->select('bookings.*, users.username as username, motors.name AS motor_name, motors.number_plate AS number_plate')
            ->join('motors', 'motors.id = bookings.motor_id')
            ->join('users', 'users.id = bookings.user_id')
            ->findAll();


        $logs = $builder->select('motor_logbooks.*, motor_logbooks.created_at as waktu, motors.number_plate as number_plate, motors.name as motor, users.username as penyewa')
            ->join('motors', 'motors.id = motor_logbooks.motor_id')
            ->join('users', 'users.id = motor_logbooks.user_id')
            ->join('bookings', 'bookings.id = motor_logbooks.booking_id', 'left')
            ->orderBy('motor_logbooks.created_at', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Logbook',
            'submenu_title' => 'Logbook',
            'logs' => $logs,
            'motors' => $motors,
            'bookings' => $bookings,
        ];
        return view('dashboard/logbook/logbook', $data);
    }

    public function getMotorStatus($motorId): ResponseInterface
    {
        $last = $this->MotorLogbook->where('motor_id', $motorId)
            ->orderBy('created_at', 'DESC')
            ->first();

        $status = 'available';
        if ($last && $last['type'] === 'check-out') {
            $status = 'in-use';
        }

        return $this->response->setJSON(['status' => $status]);
    }

    public function store()
    {
        $photoFile = $this->request->getFile('photo');

        $motorId   = $this->request->getPost('motor_id') ?? $this->request->getPost('motor_id_hidden');
        $bookingId = $this->request->getPost('booking_id');
        $type      = $this->request->getPost('type');
        $notes     = $this->request->getPost('notes');
        $fuel = $this->request->getPost('fuel');
        $user_id  = session()->get('id');


        $validationRules = [
            'motor_id' => [
                'rules' => 'required|integer|is_not_unique[motors.id]',
                'errors' => [
                    'is_not_unique' => 'Motor tidak ditemukan.',
                    'required' => 'Motor harus dipilih.',
                    'integer' => 'Motor tidak valid.',
                ]
            ],
            'type' => [
                'rules' => 'required|in_list[check-in,check-out]',
                'errors' => [
                    'required' => 'Jenis logbook harus dipilih.',
                    'in_list' => 'Jenis logbook tidak valid.',
                ]
            ],
            'fuel' => [
                'rules' => 'required|in_list[full,medium,low]',
                'errors' => [
                    'required' => 'Fuel level harus dipilih.',
                    'in_list' => 'Fuel level tidak valid.',
                ]
            ],
            'photo' => [
                'rules' => 'permit_empty|is_image[photo]|max_size[photo,2048]|mime_in[photo,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'max_size' => 'Ukuran gambar maksimal 2MB.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.',
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors())->with('modal', 'logbookModal');
        }

        if (!$motorId || !$type) {
            return redirect()->back()->withInput()->with('errors', 'Data tidak lengkap.')->with('modal', 'logbookModal');
        }

        // VALIDASI STATUS MOTOR
        if ($type === 'check-out') {
            if ($this->MotorLogbook->isMotorAvailable($motorId)) {
                return redirect()->back()->with('error', 'Motor sudah di check-out.');
            }
        }

        if ($type === 'check-in') {
            if (!$this->MotorLogbook->isMotorAvailable($motorId)) {
                return redirect()->back()->with('error', 'Motor belum di check-out.');
            }
        }

        // ==== HANDLE FOTO ====
        $photoName = null;
        if ($photoFile && $photoFile->isValid()) {
            $photoName = $photoFile->getRandomName();
            $photoFile->move(ROOTPATH . 'public/uploads/logbook', $photoName);
        } else {
            $photoName = null;
        }

        $kode = 'LB' . date('YmdHis');

        $this->MotorLogbook->insert([
            'kode'           => $kode,
            'motor_id'       => $motorId,
            'user_id'        => $user_id,
            'booking_id'     => $bookingId ?: null,
            'type'           => $type,
            'condition_note' => $notes,
            'fuel_level' => $fuel,
            'photo' => $photoName,
        ]);

        return redirect()->back()->with(
            'success',
            $type === 'check-in'
                ? 'Motor berhasil di Check In.'
                : 'Motor berhasil di Check Out.'
        );
    }
}
