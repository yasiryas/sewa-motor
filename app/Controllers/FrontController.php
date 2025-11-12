<?php

namespace App\Controllers;

use App\Models\BrandModel;
use App\Models\MotorModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

class FrontController extends BaseController
{
    protected $MotorModel;
    protected $BrandModel;
    public function __construct()
    {
        $this->MotorModel = new MotorModel();
        $this->BrandModel = new BrandModel();
    }
    public function index()
    {
        $MotorModel = new MotorModel();
        $data = [
            'title' => 'Beranda',
            'motors' => $MotorModel
                ->select('motors.*, brands.brand as brand, types.type as type')
                ->join('brands', 'brands.id = motors.id_brand')
                ->join('types', 'types.id = motors.id_type')
                ->limit(8)
                ->findAll(),
            'brands' => $this->BrandModel->asObject()->findAll(),

        ];
        return view('frontend/home', $data);
    }

    public function produk()
    {
        $data = [
            'title' => 'Produk',
            'motors' => $this->MotorModel->findAll(),
            'brands' => $this->BrandModel->findAll(),
        ];
        return view('frontend/produk', $data);
    }

    public function searchAjaxProduk()
    {
        $keyword = $this->request->getGet('keyword');

        $motors = $this->MotorModel
            ->select('motors.*, brands.brand as brand, types.type as type')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('types', 'types.id = motors.id_type')
            ->groupStart()
            ->like('motors.name', $keyword)
            ->orLike('brands.brand', $keyword)
            ->orLike('motors.description', $keyword)
            ->groupEnd()
            ->findAll();

        return $this->response->setJSON($motors);
    }

    public function filterByBrand($brandId)
    {

        $motors = $this->MotorModel
            ->select('motors.*, brands.brand as brand, types.type as type')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('types', 'types.id = motors.id_type')
            ->where('id_brand', $brandId)
            ->findAll();

        return $this->response->setJSON($motors);
    }

    public function tentang_kami()
    {
        $data = [
            'title' => 'Tentang Kami',
        ];
        return view('frontend/tentang-kami', $data);
    }
    public function faq()
    {
        $FaqModel = new \App\Models\FaqModel();
        $faqs = $FaqModel->findAll();
        $data = [
            'title' => 'FAQ',
            'faqs' => $faqs,
        ];
        return view('frontend/faq', $data);
    }
    public function kontak()
    {
        $data = [
            'title' => 'Kontak',
        ];
        return view('frontend/kontak', $data);
    }

    public function detailProduk($id)
    {
        if (!session()->get('isLoggedIn')) {
            session()->set('redirect_url', current_url());
        }
        $motor = $this->MotorModel
            ->select('motors.*, brands.brand as brand, types.type as type')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('types', 'types.id = motors.id_type')
            ->where('motors.id', $id)
            ->first();

        if (!$motor) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Motor tidak ditemukan');
        }
        $data = [
            'title' => 'Produk',
            'sub-title' => 'Detail Motor',
            'motor' => $motor,
        ];
        return view('frontend/detail-motor', $data);
    }

    public function listBookingUser()
    {
        $BookingModel = new \App\Models\BookingModel();
        $bookings = $BookingModel
            ->select(
                'bookings.*,
            motors.name as motor_name,
            motors.number_plate,
            motors.price_per_day,
            brands.brand as brand_name,
            bookings.status as status,
            bookings.rental_start_date,
            bookings.rental_end_date'
            )
            ->join('motors', 'motors.id = bookings.motor_id')
            ->join('brands', 'brands.id = motors.id_brand')
            ->where('bookings.user_id', session()->get('id'))
            ->orderBy('bookings.created_at', 'DESC')
            ->findAll();
        $data = [
            'title' => 'Daftar Pesanan',
            'bookings' => $bookings,
        ];
        return view('frontend/pesanan', $data);
    }

    public function detailBookingUser($id)
    {
        $BookingModel = new \App\Models\BookingModel();
        $booking = $BookingModel
            ->select(
                'bookings.*,
            motors.name as motor_name,
            motors.photo as photo,
            motors.number_plate,
            motors.price_per_day,
            bookings.status as status,
            brands.brand as brand_name,
            bookings.rental_start_date,
            bookings.rental_end_date'
            )
            ->join('motors', 'motors.id = bookings.motor_id')
            ->join('brands', 'brands.id = motors.id_brand')
            ->where('bookings.user_id', session()->get('id'))
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Pesanan',
            'booking' => $booking,
        ];
        // return view('frontend/detail-pesanan', $data);
        return $this->response->setJSON($data);
        // dd($data);
    }

    public function detailBookingUserPage($id)
    {
        $BookingModel = new \App\Models\BookingModel();
        $booking = $BookingModel
            ->select(
                'bookings.*,
            motors.name as motor_name,
            motors.photo as photo,
            motors.number_plate,
            motors.price_per_day,
            bookings.status as status,
            brands.brand as brand_name,
            bookings.rental_start_date,
            bookings.rental_end_date,
            payments.payment_proof as payment_proof,
            payments.payment_method as payment_method,
            payments.id as payment_id,
            payments.status as payment_status,
            payments.amount as payment_amount,
            bookings.identity_photo as identity_photo'
            )
            ->join('motors', 'motors.id = bookings.motor_id')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('payments', 'payments.booking_id = bookings.id', 'left')
            ->where('bookings.user_id', session()->get('id'))
            ->where('bookings.id', $id)
            ->first();

        if (!$booking) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Pesanan tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Pesanan',
            'booking' => $booking,
        ];
        return view('frontend/detail-pesanan', $data);
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
            // update payment table if payment proof is uploaded
            if (isset($data['payment_proof'])) {
                $paymentData = [
                    'payment_method' => $data['payment_method'],
                    'payment_proof' => $data['payment_proof'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $PayementModel->update($id_payment, $paymentData);
            } else {
                // update payment method only
                $paymentData = [
                    'payment_method' => $data['payment_method'],
                    'updated_at' => date('Y-m-d H:i:s'),
                ];
                $PayementModel->update($id_payment, $paymentData);
            }
            return redirect()->back()->with('success', 'Booking berhasil diperbarui');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui booking');
        }
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
        $html = view('frontend/invoice', ['booking' => $booking]);

        // === 3️⃣ Render ke PDF ===
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // === 4️⃣ Unduh PDF ===
        $dompdf->stream('Invoice_Booking_' . $booking['id'] . '.pdf', ['Attachment' => true]);
    }

    public function checkTime()
    {
        echo "<h3>Waktu Server</h3>";
        echo "PHP Timezone: " . date_default_timezone_get() . "<br>";
        echo "PHP Time: " . date('Y-m-d H:i:s') . "<br>";

        $db = \Config\Database::connect();
        $query = $db->query("SELECT NOW() AS waktu_mysql")->getRow();
        echo "MySQL Time: " . $query->waktu_mysql;
    }
}
