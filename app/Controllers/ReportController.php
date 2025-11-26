<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\BookingModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends BaseController
{

    public function __construct()
    {
        // Pastikan hanya admin yang bisa mengakses controller ini
        if (!session()->get('id')) {
            redirect()->to('login')->with('error', 'Anda harus login terlebih dahulu.')->send();
            exit;
        }

        if (session()->get('role') != 'admin') {
            redirect()->to('/')->with('error', 'Akses ditolak.')->send();
            exit;
        }
    }
    public function reportBooking()
    {
        $bookingModel = new BookingModel();
        $userModel = new UserModel();


        // Ambil filter date jika ada
        $start = $this->request->getGet('start_date');
        $end   = $this->request->getGet('end_date');

        $query = $bookingModel
            ->select('bookings.*, users.username as username, motors.name AS motor_name')
            ->join('users', 'users.id = bookings.user_id')
            ->join('motors', 'motors.id = bookings.motor_id');

        if ($start && $end) {
            $query->where("DATE(bookings.created_at) >=", $start)
                ->where("DATE(bookings.created_at) <=", $end);
        }

        $data = [
            'title' => 'Report',
            'submenu_title' => 'Report Booking',
            'bookings' => $query->findAll(),
        ];
        return view('dashboard/booking-report', $data);
    }

    public function exportBookingExcel()
    {
        $bookingModel = new BookingModel();

        $start = $this->request->getPost('start_date');
        $end   = $this->request->getPost('end_date');

        $query = $bookingModel
            ->select('bookings.*, users.full_name, motors.name AS motor_name')
            ->join('users', 'users.id = bookings.user_id')
            ->join('motors', 'motors.id = bookings.motor_id');

        if ($start && $end) {
            $query->where("DATE(bookings.created_at) >=", $start)
                ->where("DATE(bookings.created_at) <=", $end);
        }

        $rows = $query->findAll();

        // === Spreadsheet ===
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'User');
        $sheet->setCellValue('C1', 'Motor');
        $sheet->setCellValue('D1', 'Tanggal');
        $sheet->setCellValue('E1', 'Status');
        $sheet->setCellValue('F1', 'Total');

        // Data
        $no = 1;
        $row = 2;

        foreach ($rows as $item) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $item['full_name']);
            $sheet->setCellValue('C' . $row, $item['motor_name']);
            $sheet->setCellValue('D' . $row, $item['created_at']);
            $sheet->setCellValue('E' . $row, $item['status']);
            $sheet->setCellValue('F' . $row, $item['total_amount'] ?? 0);

            $row++;
        }

        // Export
        $fileName = 'Booking_Report_' . date('YmdHis') . '.xlsx';
        $writer = new Xlsx($spreadsheet);
        $filePath = WRITEPATH . $fileName;
        $writer->save($filePath);

        return $this->response->download($filePath, null)->setFileName($fileName);
    }

    public function getBookingData()
    {
        $bookingModel = new BookingModel();

        $start = $this->request->getPost('start_date');
        $end   = $this->request->getPost('end_date');

        $query = $bookingModel
            ->select('bookings.*, users.username as username, motors.name AS motor_name')
            ->join('users', 'users.id = bookings.user_id')
            ->join('motors', 'motors.id = bookings.motor_id');

        if ($start && $end) {
            $query->where("DATE(bookings.created_at) >=", $start)
                ->where("DATE(bookings.created_at) <=", $end);
        }

        $data = $query->findAll();

        return $this->response->setJSON($data);
    }

    public function ajaxBookings()
    {
        $bookingModel = new BookingModel();

        $start = $this->request->getPost('start_date');
        $end   = $this->request->getPost('end_date');

        $builder = $bookingModel
            ->select('bookings.*, users.full_name, motors.name as motor_name');

        if ($start && $end) {
            $builder->where('DATE(bookings.created_at) >=', $start)
                ->where('DATE(bookings.created_at) <=', $end);
        }

        $recordsTotal = $builder->countAllResults(false);

        // DATATABLES SEARCH
        $search = $this->request->getPost('search')['value'] ?? '';
        if (!empty($search)) {
            $builder->groupStart()
                ->like('users.full_name', $search)
                ->orLike('motors.name', $search)
                ->groupEnd();
        }

        $recordsFiltered = $builder->countAllResults(false);

        // LIMIT (PAGINATION)
        $length = $this->request->getPost('length');
        $start  = $this->request->getPost('start');
        $builder->limit($length, $start);

        $data = $builder->get()->getResultArray();

        $result = [];
        $no = $start + 1;
        foreach ($data as $row) {
            $result[] = [
                $no++,
                $row['full_name'],
                $row['motor_name'],
                $row['created_at'],
                ucfirst($row['status']),
                number_format($row['total_amount'])
            ];
        }

        return $this->response->setJSON([
            "draw"            => intval($this->request->getPost('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $result,
        ]);
    }
}
