<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use App\Models\MotorModel;
use App\Models\BookingModel;
use App\Models\PaymentModel;



class DashboardController extends BaseController
{
    public function index()
    {
        if (!session()->get('id')) {
            return redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        if (session()->get('role') != 'admin') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $bookingModel = new BookingModel();
        $motorModel = new MotorModel();
        $userModel = new UserModel();
        $paymentModel = new PaymentModel();


        $data = [
            'title' => 'Dashboard',
            'submenu_title' => '',
            'pending_requests' => $bookingModel->where('status', 'pending')->countAllResults(),
            'total_motors' => $motorModel->countAllResults(),
            'total_users' => $userModel->where('role', 'user')->countAllResults(),
            'monthly_revenue' => $paymentModel->where('status', 'completed')
                ->where('MONTH(created_at)', date('m'))
                ->selectSum('amount')
                ->first()['amount'] ?? 0,
        ];
        return view('dashboard/index', $data);
    }

    public function getMonthlyBookings()
    {
        $bookingModel = new BookingModel();

        // Ambil 6 bulan terakhir
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = date("Y-m", strtotime("-$i months"));
        }

        // Format hasil: ['2025-05' => 0, '2025-06' => 4, ...]
        $results = array_fill_keys($months, 0);

        $query = $bookingModel
            ->select("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as total")
            ->where("created_at >=", date("Y-m-01", strtotime("-5 months")))
            ->groupBy("month")
            ->findAll();

        foreach ($query as $row) {
            $results[$row['month']] = (int)$row['total'];
        }

        return $this->response->setJSON($results);
    }

    public function topMotors()
    {
        $bookingModel = new BookingModel();

        // Ambil bulan & tahun saat ini
        $currentMonth = date('m');
        $currentYear  = date('Y');

        // Query 5 motor paling sering dibooking bulan ini
        $result = $bookingModel
            ->select('motors.name as name, COUNT(bookings.id) as total_booking')
            ->join('motors', 'motors.id = bookings.motor_id')
            ->where('MONTH(bookings.created_at)', $currentMonth)
            ->where('YEAR(bookings.created_at)', $currentYear)
            ->groupBy('motors.id')
            ->orderBy('total_booking', 'DESC')
            ->limit(5)
            ->findAll();

        // Format agar mudah dipakai di Chart.js
        $labels = [];
        $values = [];

        foreach ($result as $row) {
            $labels[] = $row['name'];
            $values[] = (int)$row['total_booking'];
        }

        return $this->response->setJSON([
            'labels' => $labels,
            'values' => $values
        ]);
    }
}
