<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\UserModel;
use App\Models\MotorModel;
use App\Models\BookingModel;
use App\Models\PaymentModel;
use Psr\Log\LoggerInterface;
use App\Models\NotificationModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserDeviceModel;


class BookingController extends BaseController
{
    protected $BookingModel;
    protected $UserModel;
    protected $MotorModel;
    protected $PaymentModel;
    protected $NotificationModel;
    protected $UserDeviceModel;
    public function __construct()
    {
        $this->BookingModel = new BookingModel();
        $this->UserModel = new UserModel();
        $this->MotorModel = new MotorModel();
        $this->PaymentModel = new PaymentModel();
        $this->NotificationModel = new NotificationModel();
        $this->UserDeviceModel = new UserDeviceModel();
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

    /**
     * Insert booking + payment secara atomik untuk mencegah race condition
     * double-booking: baris motor dikunci (SELECT ... FOR UPDATE) sehingga
     * request paralel untuk motor yang sama diserialisasi, lalu ketersediaan
     * dicek ULANG di dalam transaksi sebelum insert.
     *
     * @return array ['booking_id' => int] atau ['error' => string]
     */
    private function insertBookingSafely($userId, $motorId, $startDate, $endDate, $totalPrice, ?string $paymentMethod = null): array
    {
        $db = \Config\Database::connect();
        $db->transBegin();

        // Kunci baris motor: request lain yang mau booking motor ini akan menunggu
        $lockedMotor = $db->query('SELECT id FROM motors WHERE id = ? FOR UPDATE', [$motorId])->getRow();

        if (!$lockedMotor) {
            $db->transRollback();
            return ['error' => 'Motor tidak ditemukan.'];
        }

        // Cek ulang overlap DI DALAM kunci — data booking tidak bisa berubah sekarang
        try {
            $availability = $this->MotorModel->isMotorAvailable($motorId, $startDate, $endDate);
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Cek ketersediaan gagal: ' . $e->getMessage());
            return ['error' => 'Terjadi kesalahan saat memeriksa ketersediaan motor.'];
        }

        if (!$availability['available']) {
            $db->transRollback();
            return [
                'error' => is_array($availability['message'])
                    ? 'Motor sudah dibooking pada tanggal tersebut.'
                    : $availability['message']
            ];
        }

        $bookingId = $this->BookingModel->insert([
            'user_id' => $userId,
            'motor_id' => $motorId,
            'rental_start_date' => $startDate,
            'rental_end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ], true);

        if (!$bookingId) {
            $db->transRollback();
            return ['error' => 'Gagal menyimpan booking. Silakan coba lagi.'];
        }

        $paymentData = [
            'booking_id' => $bookingId,
            'user_id' => $userId,
            'amount' => $totalPrice,
            'payment_date' => date('Y-m-d H:i:s'),
            'status' => 'pending',
        ];
        if ($paymentMethod !== null) {
            $paymentData['payment_method'] = $paymentMethod;
        }
        $this->PaymentModel->insert($paymentData);

        if ($db->transStatus() === false) {
            $db->transRollback();
            return ['error' => 'Gagal menyimpan booking. Silakan coba lagi.'];
        }

        $db->transCommit();

        return ['booking_id' => $bookingId];
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

        // insert booking + payment secara atomik (anti race condition)
        $result = $this->insertBookingSafely(session()->get('id'), $motorId, $startDate, $endDate, $totalPrice);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error']);
        }

        $bookingId = $result['booking_id'];

        $user = $this->UserModel->find(session()->get('id'));
        $bookingData = [
            'booking_id' => $bookingId,
            'motor_name' => $motor['name'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'days' => $days
        ];

        sendBookingEmail($user['email'], $user['full_name'], $bookingData);

        $adminData = [
            'user_name' => $user['full_name'],
            'booking_id' => $bookingId,
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
        ];
        return view('dashboard/booking', $data);
    }

    public function reportBooking()
    {
        $data = [
            'title' => 'Report',
            'submenu_title' => 'Report Booking',
            'user' => (new \App\Models\UserModel())->find(session()->get('id')),
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

        // calculate total price
        $start = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $interval = $start->diff($end);
        $days = $interval->days + 1; // include start day
        $total_price = $days * $motor['price_per_day'];

        // insert booking + payment secara atomik (anti race condition)
        $result = $this->insertBookingSafely($user_id, $motor_id, $start_date, $end_date, $total_price, $payment_method);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error'])->withInput()->with('modal', 'addBookingModal');
        }

        $bookingID = $result['booking_id'];

        // Get user data for email
        $user = $this->UserModel->find(session()->get('id'));

        $bookingData = [
            'user_name' => $user['full_name'],
            'booking_id' => $bookingID,
            'motor_name' => $motor['name'],
            'start_date' => $start_date,
            'end_date' => $end_date,
            'total_price' => $total_price,
            'days' => $days,
        ];

        $emailResult = sendBookingEmail($user['email'], $user['full_name'], $bookingData);

        $adminData = [
            'user_name' => $user['full_name'],
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

        // calculate total price
        $start = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $interval = $start->diff($end);
        $days = $interval->days + 1; // include start day
        $total_price = $days * $motor['price_per_day']; // include start day

        // insert booking + payment secara atomik (anti race condition)
        $result = $this->insertBookingSafely($user_id, $motor_id, $start_date, $end_date, $total_price, 'cash');

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error'])->with('modal', 'addBookingModal')->withInput();
        }

        $bookingID = $result['booking_id'];

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
        $deviceModel = new \App\Models\UserDeviceModel();
        $adminIds = $this->UserModel->where('role', 'admin')->findColumn('id');
        $tokens = $adminIds ? ($deviceModel->whereIn('user_id', $adminIds)->findColumn('fcm_token') ?? []) : [];

        sendFCM(
            $tokens,
            'Booking Baru',
            'Ada booking baru dari ' . $user['username'] . '.',
            base_url('admin/bookings')
        );

        $notificationModel = new \App\Models\NotificationModel();
        if (!empty($adminIds)) {
            $notificationModel->insertBatch(array_map(function ($adminId) use ($user) {
                return [
                    'user_id' => $adminId,
                    'type' => 'booking',
                    'title' => 'Booking Baru',
                    'message' => 'User ' . $user['username'] . ' membuat booking',
                    'link' => base_url('/dashboard/booking'),
                    'is_read' => 0
                ];
            }, $adminIds));
        }


        return redirect()->to('booking/detail-booking-page/' . $bookingID)->with('modal', 'addBookingModal')->with('success', 'Booking berhasil! Segera lakukan pembayaran ya agar bookingan anda dapat segera diproses.');
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
        helper('email_helper');

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

        $user = $this->UserModel->find($booking['user_id']);
        $motor = $this->MotorModel->find($booking['motor_id']);
        $bookingData = [
            'booking_id' => $bookingId,
            'motor_name' => $motor['name'],
            'start_date' => $booking['rental_start_date'],
            'end_date' => $booking['rental_end_date'],
            'total_price' => $booking['total_price'],
            'status' => $status
        ];

        sendBookingStatusEmail($user['email'], $user['username'], $bookingId, $status, $bookingData);

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

        // ambil user pembatal
        $user = $this->UserModel->find(session()->get('id'));

        // ambil semua admin
        $adminRows = $this->UserModel
            ->where('role', 'admin')
            ->findAll();
        $adminIds = array_column($adminRows, 'id');

        //send email to admin
        helper('email_helper');
        foreach ($adminRows as $admin) {
            sendAdminCancelNotification(
                $admin['email'],
                [
                    'user_name'  => $user['username'],
                    'booking_id' => $id
                ]
            );
        }

        // FCM Admin (satu query untuk semua token)
        $deviceModel = new \App\Models\UserDeviceModel();
        $tokens = !empty($adminIds)
            ? ($deviceModel->whereIn('user_id', $adminIds)->findColumn('fcm_token') ?? [])
            : [];

        if (!empty($tokens)) {
            sendFCM(
                $tokens,
                'Booking Dibatalkan',
                'User ' . $user['username'] . ' membatalkan booking',
                base_url('admin/bookings')
            );
        }

        // Notif database (batch insert)
        $notificationModel = new \App\Models\NotificationModel();
        if (!empty($adminIds)) {
            $notificationModel->insertBatch(array_map(function ($adminId) use ($user, $id) {
                return [
                    'user_id' => $adminId,
                    'type'    => 'cancel',
                    'title'   => 'Booking Dibatalkan',
                    'message' => 'User ' . $user['username'] . ' membatalkan booking',
                    'link'    => base_url('admin/bookings'),
                    'is_read' => 0
                ];
            }, $adminIds));
        }

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

    public function invoice($id)
    {
        $BookingModel = new \App\Models\BookingModel();
        $PaymentModel = new \App\Models\PaymentModel();

        $booking = $BookingModel
            ->select('bookings.*,
        payments.amount,
        payments.status as payment_status,
        payments.payment_method,
        payments.payment_proof,
        brands.brand as brand_name,
        motors.name as motor_name,
        motors.number_plate,
        motors.price_per_day,
        users.full_name,
        users.phone,
        users.email,
        types.type as type_name')
            ->join('payments', 'payments.booking_id = bookings.id', 'left')
            ->join('motors', 'motors.id = bookings.motor_id', 'left')
            ->join('brands', 'brands.id = motors.id_brand', 'left')
            ->join('types', 'types.id = motors.id_type', 'left')
            ->join('users', 'users.id = bookings.user_id', 'left')
            ->find($id);

        if (!$booking) {
            return redirect()->back()->with('error', 'Data booking tidak ditemukan');
        }

        // === 1️⃣ Setup opsi Dompdf ===
        $options = new Options();
        $options->set('isRemoteEnabled', true); // agar logo bisa di-load dari base_url
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // === 2️⃣ Siapkan HTML ===
        $html = view('dashboard/invoice', ['booking' => $booking]);

        // === 3️⃣ Render ke PDF ===
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // === 4️⃣ Unduh PDF ===
        $dompdf->stream('Invoice_Booking_' . $booking['id'] . '.pdf', ['Attachment' => true]);
    }

    public function updateBookingFromDetailUser()
    {
        $BookingModel = new \App\Models\BookingModel();
        $PayementModel = new \App\Models\PaymentModel();

        $id_booking = $this->request->getPost('id_booking');
        $id_payment = $this->request->getPost('id_payment');

        $booking = $BookingModel->find($id_booking);
        if (!$booking) {
            return redirect()->back()->with('error', 'Booking tidak ditemukan');
        }

        $data = [
            'payment_method' => $this->request->getPost('payment_method'),
            'notes' => $this->request->getPost('notes'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // upload identitiy photo
        $identityFile = $this->request->getFile('identity_photo');
        if ($identityFile && $identityFile->isValid()) {
            $identityPhotoName = 'identity_' . time() . '.' . $identityFile->getClientExtension();
            $identityFile->move('uploads/identitas/', $identityPhotoName);
            $data['identity_photo'] = $identityPhotoName;
        }

        // upload bukti pembayaran
        $proofFile = $this->request->getFile('payment_proof');
        if ($proofFile && $proofFile->isValid()) {
            $paymentProofName = 'payment_proof_' . time() . '.' . $proofFile->getClientExtension();
            $proofFile->move('uploads/payments/', $paymentProofName);
            $data['payment_proof'] = $paymentProofName;
        }

        if ($BookingModel->update($id_booking, $data)) {
            // update payment table (method selalu, bukti hanya jika diupload)
            $paymentData = [
                'payment_method' => $data['payment_method'],
                'updated_at' => date('Y-m-d H:i:s'),
            ];
            if (isset($data['payment_proof'])) {
                $paymentData['payment_proof'] = $data['payment_proof'];
            }
            $PayementModel->update($id_payment, $paymentData);

            if (isset($data['payment_proof'])) {
                $user = $this->UserModel->find(session()->get('id'));
                $admins = $this->UserModel->where('role', 'admin')->findAll();
                $adminIds = array_column($admins, 'id');

                helper('email_helper', 'firebase_helper');

                foreach ($admins as $admin) {
                    sendAdminPeymentConfirmationEmail(
                        $admin['email'],
                        [
                            'email_user' => $user['email'],
                            'user_name' => $user['full_name'],
                            'booking_id' => $booking['id'],
                            'payment_proof' => $data['payment_proof'],
                            'amount' => $booking['total_price']
                        ]
                    );
                }

                // Notif database (batch insert)
                $notificationData = array_map(function ($adminId) use ($user, $booking) {
                    return [
                        'user_id' => $adminId,
                        'type' => 'payment_confirmation',
                        'title' => 'Konfirmasi Pembayaran Dikirim',
                        'message' => 'User ' . $user['full_name'] . ' telah mengirimkan bukti pembayaran untuk booking ID #' . $booking['id'] . '. Silakan lakukan verifikasi.',
                        'link' => '/dashboard/booking/detail/' . $booking['id'],
                        'is_read' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                }, $adminIds);
                $this->NotificationModel->insertBatch($notificationData);

                // FCM Admin (satu query untuk semua token)
                $tokens = !empty($adminIds)
                    ? ($this->UserDeviceModel->whereIn('user_id', $adminIds)->findColumn('fcm_token') ?? [])
                    : [];

                if (!empty($tokens)) {
                    sendFCM(
                        $tokens,
                        'Konfirmasi Pembayaran Dikirim',
                        'User ' . $user['full_name'] . ' telah mengirimkan bukti pembayaran untuk booking ID #' . $booking['id'] . '. Silakan lakukan verifikasi.',
                        '/dashboard/booking/detail/' . $booking['id']
                    );
                }
            }
            return redirect()->back()->with('success', 'Booking berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui booking');
        }
    }
}
