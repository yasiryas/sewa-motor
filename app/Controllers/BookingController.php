<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RequestInterface;
use Psr\Log\LoggerInterface;

class BookingController extends BaseController
{
    public function index()
    {
        //
        $data['bookings'] = $this->bookingModel->findAll();
        return view('bookings/index', $data);
    }
    public function view($id)
    {
        //
        $data['booking'] = $this->bookingModel->find($id);
        if (!$data['booking']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booking not found');
        }
        return view('bookings/view', $data);
    }
}
