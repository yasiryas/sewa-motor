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
        $data = [
            'title' => 'Logbook',
            'submenu_title' => 'Logbook',
            'logbook' => [], // Data FAQ akan diisi nanti jika adanull,
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
