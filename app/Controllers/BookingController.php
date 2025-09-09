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

    protected $BookingModel;
    public function __construct()
    {
        $this->BookingModel = new BookingModel();
    }

    public function index()
    {
        //
        $data['bookings'] = $this->BookingModel->findAll();
        return view('booking/index', $data);
    }

    public function store()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

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

        if ($endDate < $startDate) {
            return redirect()->back()->with('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai');
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

    public function dashboard()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $bookingModel = new BookingModel();
        $data = [
            'title' => 'Booking',
            'submenu_title' => '',
            'user' => (new \App\Models\UserModel())->find(session()->get('id')),
            'motors' => (new \App\Models\MotorModel())->countAllResults(),
            'bookings' => $bookingModel
                ->select('bookings.*, users.username, motors.name as motor_name')
                ->join('users', 'users.id = bookings.user_id')
                ->join('motors', 'motors.id = bookings.motor_id')
                ->findAll(),
        ];
        return view('dashboard/booking', $data);
    }

    public function reportBooking()
    {
        $data = [
            'title' => 'Report',
            'submenu_title' => 'Report Booking',
            'user' => (new \App\Models\UserModel())->find(session()->get('id')),
            'bookings' => $this->BookingModel->findAll(),
        ];
        return view('dashboard/booking-report', $data);
    }
}
