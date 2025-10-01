<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookingModel;
use App\Models\MotorModel;
use App\Models\PaymentModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BookingController extends BaseController
{

    protected $BookingModel;
    protected $UserModel;
    protected $MotorModel;
    protected $PaymentModel;
    public function __construct()
    {
        $this->BookingModel = new BookingModel();
        $this->UserModel = new \App\Models\UserModel();
        $this->MotorModel = new MotorModel();
        $this->PaymentModel = new \App\Models\PaymentModel();
    }

    public function index()
    {
        //
        $data = [
            'title' => 'Booking',
            'submenu_title' => '',
            'motors' => (new \App\Models\MotorModel())->findAll(),
            'user' => $this->UserModel->find(session()->get('id')),
            'bookings' => $this->BookingModel->where('user_id', session()->get('id'))->findAll(),
            'users' => $this->UserModel->where('role', 'user')->findAll(),
        ];
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
        ]);

        // insert to payment
        $paymentModel = new \App\Models\PaymentModel();
        $paymentModel->insert([
            'user_id' => session()->get('id'),
            'motor_id' => $motorId,
            'rental_start_date' => $startDate,
            'rental_end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => 'pending',
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
            'user' => $this->UserModel->find(session()->get('id')),
            'users' => $this->UserModel->where('role', 'user')->findAll(),
            'motors' => $this->MotorModel->findAll(),
            'bookings' => $bookingModel
                ->select('bookings.*, users.username, motors.name as motor_name')
                ->join('users', 'users.id = bookings.user_id')
                ->join('motors', 'motors.id = bookings.motor_id')
                ->findAll(),
            'payments' => $this->PaymentModel->findAll(),
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

    public function adminStore()
    {
        // code to store booking by admin
        $validationRules = [
            'user_id' => [
                'label' => 'User',
                'rules' => 'required|is_not_unique[users.id]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'is_not_unique' => '{field} tidak ditemukan.'
                ]
            ],
            'motor_id' => [
                'label' => 'Motor',
                'rules' => 'required|is_not_unique[motors.id]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'is_not_unique' => '{field} tidak ditemukan.'
                ]
            ],
            'rental_start_date' => [
                'label' => 'Tanggal Mulai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'valid_date' => '{field} bukan tanggal yang valid.'
                ]
            ],
            'rental_end_date' => [
                'label' => 'Tanggal Selesai',
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'valid_date' => '{field} bukan tanggal yang valid.'
                ]
            ],
            'payment_method' => [
                'label' => 'Metode Pembayaran',
                'rules' => 'required|in_list[cash,transfer]',
                'errors' => [
                    'required' => '{field} harus diisi.',
                    'in_list' => '{field} tidak valid.'
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->with('error', $this->validator->listErrors())->withInput()->with('modal', 'addBookingModal');
        }

        $user_id = $this->request->getPost('user_id');
        $motor_id = $this->request->getPost('motor_id');
        $start_date = $this->request->getPost('rental_start_date');
        $end_date = $this->request->getPost('rental_end_date');
        $search_user = $this->request->getPost('search_user');
        $payment_method = $this->request->getPost('payment_method');

        // get data motor
        $motorModel = new MotorModel();
        $motor = $motorModel->find($motor_id);

        if ($end_date < $start_date) {
            return redirect()->back()->with('error', 'Tanggal selesai tidak boleh sebelum tanggal mulai')->withInput()->with('modal', 'addBookingModal');
        }

        if ($start_date < date('Y-m-d')) {
            return redirect()->back()->with('error', 'Tanggal mulai tidak boleh sebelum hari ini')->withInput()->with('modal', 'addBookingModal');
        }

        $conflict = $this->BookingModel->where('motor_id', $motor_id)
            ->where('status !=', 'canceled')
            ->where('rental_start_date <=', $end_date)
            ->where('rental_end_date >=', $start_date)
            ->first();

        if ($conflict) {
            return redirect()->back()->with('error', 'Motor sudah dibooking pada tanggal tersebut.')->withInput()->with('modal', 'addBookingModal');
        }

        // calculate total price
        $start = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $interval = $start->diff($end);
        $days = $interval->days + 1; // include start day
        $total_price = $days * $motor['price_per_day'];

        $bookingModel = new BookingModel();
        $paymentModel = new PaymentModel();
        // insert to database
        $bookingID = $bookingModel->insert([
            'user_id' => $user_id,
            'motor_id' => $motor_id,
            'rental_start_date' => $start_date,
            'rental_end_date' => $end_date,
            'total_price' => $total_price,
            'status' => 'pending',
        ]);

        $paymentModel->insert([
            'booking_id' => $bookingID,
            'user_id' => $user_id,
            'amount' => $total_price,
            'payment_date' => date('Y-m-d H:i:s'),
            'payment_method' => $payment_method,
            'status' => 'pending',
            'payment_proof' => null,
        ]);

        return redirect()->back()->with('success', 'Booking berhasil! Total harga: Rp ' . number_format($total_price));
    }

    public function deleteAdmin()
    {
        $id = $this->request->getPost('id');
        $booking = $this->BookingModel->find($id);
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan.')->with('modal', 'deleteBookingAdminModal');
        }

        $this->BookingModel->delete($id);
        return redirect()->back()->with('success', 'Booking berhasil dihapus.');
    }

    public function getAvialableMotorsBooking()
    {
        $start_date = $this->request->getGet('start');
        $end_date = $this->request->getGet('end');
        $motors = $this->MotorModel->getAvialableMotorsBooking($start_date, $end_date);
        return $this->response->setJSON($motors);
    }

    public function detail($id)
    {
        $bookingModel = new BookingModel();
        $paymentModel = new PaymentModel();

        $booking = $bookingModel->find($id);
        if (!$booking) {
            return $this->response->setJSON(['error' => 'Booking tidak ditemukan']);
        }

        $payment = $paymentModel->where('booking_id', $id)->first();

        return $this->response->setJSON([
            'booking' => $booking,
            'payment' => $payment
        ]);
    }
}
