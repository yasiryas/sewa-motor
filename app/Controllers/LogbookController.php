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
            ->select('bookings.*, users.username as username, motors.name AS motor_name')
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

    public function checkOut()
    {
        $motorId = $this->request->getPost('motor_id');
        $bookingId = $this->request->getPost('booking_id');
        $notes = $this->request->getPost('notes');

        if (!$this->MotorLogbook->isMotorAvailable($motorId)) {
            return redirect()->back()->with('error', 'Motor Masih digunakan.');
        }

        $this->MotorLogbook->insert([
            'motor_id' => $motorId,
            'user_id' => session()->get('user_id'),
            'booking_id' => $bookingId,
            'type' => 'check-out',
            'condition_note' => $notes,
        ]);

        return redirect()->back()->with('success', 'Motor berhasil di check-in.');
    }

    public function checkIn()
    {
        $motorId = $this->request->getPost('motor_id');
        $bookingId = $this->request->getPost('booking_id');
        $notes = $this->request->getPost('notes');

        if ($this->MotorLogbook->isMotorAvailable($motorId)) {
            return redirect()->back()->with('error', 'Motor belum di check-out.');
        }

        $this->MotorLogbook->insert([
            'motor_id' => $motorId,
            'user_id' => session()->get('user_id'),
            'booking_id' => $bookingId,
            'type' => 'check-in',
            'condition_note' => $notes,
        ]);

        return redirect()->back()->with('success', 'Motor berhasil di check-in.');
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
}
