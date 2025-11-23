<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MotorModel;
use App\Models\BookingModel;
use App\Models\PaymentModel;
use Psr\Log\LoggerInterface;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;


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

        $availability = $this->MotorModel->isMotorAvailable($motorId, $startDate, $endDate);

        if (!$availability['available']) {
            return redirect()->back()->with('error', $availability['message']);
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

        $user = $this->UserModel->find(session()->get('id'));
        $bookingData = [
            'booking_id' => $bookingModel->getInsertID(),
            'motor_name' => $motor['name'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'days' => $days
        ];

        sendBookingEmail($user['email'], $user['name'], $bookingData);

        $adminData = [
            'user_name' => $user['name'],
            'booking_id' => $bookingModel->getInsertID(),
            'motor_name' => $motor['name'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice
        ];

        sendAdminNotification($adminData);

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
                ->orderBy('bookings.created_at', 'DESC')
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

        $availability = $this->MotorModel->isMotorAvailable($motor_id, $start_date, $end_date);

        if (!$availability['available']) {
            return redirect()->back()->with('error', $availability['message'])->withInput()->with('modal', 'addBookingModal');
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

        // Get user data for email
        $user = $this->UserModel->find(session()->get('id'));

        $bookingData = [
            'user_name' => $user['name'],
            'booking_id' => $bookingID,
            'motor_name' => $motor['name'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_price' => $total_price,
            'days' => $days,
        ];

        $emailResult = sendBookingEmail($user['email'], $user['name'], $bookingData);

        $adminData = [
            'user_name' => $user['name'],
            'booking_id' => $bookingID,
            'motor_name' => $motor['name'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_price' => $total_price
        ];
        sendAdminNotification($adminData);

        if (!$emailResult) {
            return redirect()->back()->with('error', 'Gagal mengirim email')->withInput()->with('modal', 'addBookingModal');
        }

        return redirect()->back()->with('success', 'Booking berhasil! Total harga: Rp ' . number_format($total_price));
    }

    public function userStore()
    {
        $this->validate([
            'tanggal_sewa' => [
                'required',
                'errors' => [
                    'required' => 'Tanggal sewa harus diisi.',

                ]
            ],
            'tanggal_kembali' => [
                'required',
                'errors' => [
                    'required' => 'Tanggal kembali harus diisi.',

                ]
            ],
        ]);

        if ($this->request->getPost('tanggal_sewa') < date('Y-m-d')) {
            return redirect()->back()->with('error', 'Ups! Tanggal sewa tidak boleh kurang dari saat ini!')->with('modal', 'addBookingModal')->withInput();
        }

        if ($this->request->getPost('tanggal_kembali') < $this->request->getPost('tanggal_sewa')) {
            return redirect()->back()->with('error', 'Tanggal kembali tidak boleh sebelum tanggal sewa.')->with('modal', 'addBookingModal')->withInput();
        }

        if (!session()->get('isLoggedIn')) {
            return redirect()->back()->with('error', 'Anda harus login terlebih dahulu.')->with('modal', 'addBookingModal');
        }

        $motor_id = $this->request->getPost('motor_id');
        $start_date = $this->request->getPost('tanggal_sewa');
        $end_date = $this->request->getPost('tanggal_kembali');
        $user_id = session()->get('id');

        // get data motor
        $motorModel = new MotorModel();
        $motor = $motorModel->find($motor_id);

        if (!$motor) {
            return redirect()->back()->with('error', 'Motor tidak ditemukan.')->with('modal', 'addBookingModal')->withInput();
        }

        try {
            //cek motor available
            $availability = $this->MotorModel->isMotorAvailable($motor_id, $start_date, $end_date);

            if (!$availability['available']) {
                $errorMessage = is_array($availability['message']) ? 'Motor tidak tersedia pada tanggal yang dipilih.' : $availability['message'];

                return redirect()->back()->with('error', $errorMessage)->with('modal', 'addBookingModal')->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memeriksa ketersediaan motor: ' . $e->getMessage())->with('modal', 'addBookingModal')->withInput();
        }

        // calculate total price
        $start = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $interval = $start->diff($end);
        $days = $interval->days + 1; // include start day
        $total_price = $days * $motor['price_per_day']; // include start day

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
            'payment_method' => 'cash',
            'status' => 'pending',
            'payment_proof' => null,
        ]);

        // Get user data for email
        helper('email_helper');
        $user = $this->UserModel->find($user_id);

        $bookingData = [
            'booking_id' => $bookingID,
            'motor_name' => $motor['name'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_price' => $total_price,
            'days' => $days
        ];

        // Send email notification
        $emailResult = sendBookingEmail($user['email'], $user['username'], $bookingData);

        if ($emailResult) {
            log_message('info', 'Email berhasil dikirim ke: ' . $user['email']);
        } else {
            log_message('error', 'Gagal mengirim email ke: ' . $user['email']);
        }

        $adminData = [
            'user_name' => $user['username'],
            'booking_id' => $bookingID,
            'motor_name' => $motor['name'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_price' => $total_price
        ];

        sendAdminNotification($adminData);

        return redirect('booking/pesanan')->with('success', 'Booking berhasil! Total harga: Rp ' . number_format($total_price));
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
        $bookingModel = new \App\Models\BookingModel();

        $data = $bookingModel
            ->select('bookings.*,
            payments.amount,
            payments.status as payment_status,
            users.username,
            users.email,
            motors.name as motor_name,
            motors.number_plate,
            motors.price_per_day,
            brands.brand as brand_name,
            types.type as type_name,
            payments.payment_proof,
            bookings.status as booking_status
            ')
            ->join('payments', 'payments.booking_id = bookings.id', 'left')
            ->join('users', 'users.id = bookings.user_id', 'left')
            ->join('motors', 'motors.id = bookings.motor_id', 'left')
            ->join('brands', 'brands.id = motors.id_brand', 'left')
            ->join('types', 'types.id = motors.id_type', 'left')
            ->where('bookings.id', $id)
            ->first();

        if (!$data) {
            return $this->response->setJSON(['error' => 'Booking tidak ditemukan']);
        }

        return $this->response->setJSON($data);
    }

    public function updateStatus($bookingId)
    {
        $status = $this->request->getPost('status');

        $paymentModel = new \App\Models\PaymentModel();
        $bookingModel = new \App\Models\BookingModel();

        $payment = $paymentModel->where('booking_id', $bookingId)->first();
        $booking = $bookingModel->find($bookingId);

        if (!$payment || !$booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan.');
        }

        // Tentukan status booking
        $bookingStatus = ($status === 'completed') ? 'confirmed' : 'canceled';

        // Update payment
        $paymentModel->update($payment['id'], [
            'status' => $status
        ]);

        // Update booking
        $bookingModel->update($bookingId, [
            'status' => $bookingStatus
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function getBookingDeatail($id)
    {
        $booking = $this->BookingModel
            ->select(
                'bookings.*,
            motors.name as motor_name,
            motors.photo as photo,
            motors.number_plate,
            motors.price_per_day,
            brands.brand as brand_name,
            bookings.status as status,
            brands.brand as brand_name,
            bookings.rental_start_date,
            bookings.rental_end_date,
            payments.status as payment_status,
            payments.amount as payment_amount,
            payments.payment_method as payment_method,
            payments.payment_proof as payment_proof,'
            )
            ->join('motors', 'motors.id = bookings.motor_id')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('payments', 'payments.booking_id = bookings.id', 'left')
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) {
            return $this->response->setJSON(['error' => 'Booking tidak ditemukan']);
        }

        return $this->response->setJSON($booking);
    }

    public function cancelBookingUser($id)
    {
        $booking = $this->BookingModel->find($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan.');
        }

        if ($booking['user_id'] != session()->get('id')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk membatalkan booking ini.');
        }

        if ($booking['status'] == 'canceled') {
            return redirect()->back()->with('error', 'Booking sudah dibatalkan.');
        }

        $this->BookingModel->update($id, [
            'status' => 'canceled'
        ]);

        $this->PaymentModel->where('booking_id', $id)->set(['status' => 'canceled'])->update();

        return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function checkMotorAvailability()
    {
        $motorId = $this->request->getGet('motor_id');
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        if (!$motorId || !$startDate || !$endDate) {
            return $this->response->setJSON([
                'available' => false,
                'message' => 'Data tidak lengkap'
            ]);
        }

        $motorModel = new MotorModel();
        $availability = $motorModel->isMotorAvailable($motorId, $startDate, $endDate);

        return $this->response->setJSON($availability);
    }
}
