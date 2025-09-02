<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\MotorModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BookingController extends BaseController
{

    public function __construct()
    {
        $this->BookingModel = new BookingModel();
    }

    public function index()
    {
        //
        $data['bookings'] = $this->BookingModel->findAll();
        return view('bookings/index', $data);
    }

    public function store()
    {
        $motorId = $this->request->getPost('motor_id');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        // validation
        if (!$motorId || !$startDate || !$endDate) {
            return redirect()->back()->with('error', 'Ups! Data harus lengkap');
        }

        // get data motor
        $motorModel = new MotorModel();
        $motor = $motorModel->find($motorId);

        if (!$motor) {
            return redirect()->back()->with('error', 'Motor tidak ditemukan');
        }

        // calculate total price
        $start = new \DateTime($startDate);
        $end = new \DateTime($endDate);
        $interval = $start->diff($end);
        $days = $interval->days + 1; // include start day
        $totalPrice = $days * $motor['price_per_day'];

        // insert to database
        $bookingModel = new BookingModel();
        $bookingModel->insert([
            'user_id' => session()->get('id'),
            'motor_id' => $motorId,
            'rental_start_date' => $startDate,
            'rental_end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => 'pending',
            // 'created_at' => date('Y-m-d H:i:s'),
            // 'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('booking/success')->with('success', 'Booking berhasil! Total harga: Rp ' . number_format($totalPrice));
    }

    public function success()
    {
        return view('booking/success');
    }
    public function view($id)
    {
        //
        $data['booking'] = $this->BookingModel->find($id);
        if (!$data['booking']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Booking not found');
        }
        return view('bookings/view', $data);
    }
}
