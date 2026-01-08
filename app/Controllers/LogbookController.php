<?php

namespace App\Controllers;

use App\Models\MotorLogbookModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class LogbookController extends BaseController
{
    protected $MotorLogbook;
    public function __construct()
    {
        $this->MotorLogbook = new MotorLogbookModel();
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

        $logs = $builder->select('motor_logbooks.*, motor_logbooks.created_at as waktu, motors.name as motor, users.username as penyewa')
            ->join('motors', 'motors.id = motor_logbooks.motor_id')
            ->join('users', 'users.id = motor_logbooks.user_id')
            ->findAll();

        // dd($logs);
        // ->OrderBy('created_at', 'DESC');

        $data = [
            'title' => 'Logbook',
            'submenu_title' => 'Logbook',
            'logs' => $logs,
        ];
        return view('dashboard/logbook/logbook', $data);
    }

    public function checkIn()
    {
        $data = [
            'title' => 'Logbook',
            'submenu_title' => 'Check In',
            'checkIn' => [], // Data FAQ akan diisi nanti jika adanull,
        ];
        return view('dashboard/logbook/check-in', $data);
    }
}
