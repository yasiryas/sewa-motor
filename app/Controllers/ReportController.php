<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\MotorModel;
use App\Models\BookingModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

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
            ->select('bookings.*, users.username, motors.name AS motor_name')
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
            $sheet->setCellValue('B' . $row, $item['username']);
            $sheet->setCellValue('C' . $row, $item['motor_name']);
            $sheet->setCellValue('D' . $row, date('d-m-Y', strtotime($item['created_at'])));
            $sheet->setCellValue('E' . $row, $item['status']);
            $sheet->setCellValue('F' . $row, $item['total_price'] ?? 0);

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
            ->select('bookings.*, users.username as username, motors.name as motor_name')
            ->join('users', 'users.id = bookings.user_id')
            ->join('motors', 'motors.id = bookings.motor_id')
            ->orderBy('bookings.created_at', 'DESC');

        if ($start && $end) {
            $builder->where('DATE(bookings.created_at) >=', $start)
                ->where('DATE(bookings.created_at) <=', $end);
        }

        $recordsTotal = $builder->countAllResults(false);

        // DATATABLES SEARCH
        $search = $this->request->getPost('search')['value'] ?? '';
        if (!empty($search)) {
            $builder->groupStart()
                ->like('users.username', $search)
                ->orLike('motors.name', $search)
                ->groupEnd();
        }

        $recordsFiltered = $builder->countAllResults(false);

        // LIMIT (PAGINATION)
        $length = (int) $this->request->getPost('length');
        $start  = (int) $this->request->getPost('start');
        $builder->limit($length, $start);

        $data = $builder->get()->getResultArray();

        $result = [];
        $no = $start + 1;
        foreach ($data as $row) {
            $result[] = [
                $no++,
                $row['username'],
                $row['motor_name'],
                $row['created_at'],
                ucfirst($row['status']),
                number_format($row['total_price'])
            ];
        }

        return $this->response->setJSON([
            "draw"            => intval($this->request->getPost('draw')),
            "recordsTotal"    => $recordsTotal,
            "recordsFiltered" => $recordsFiltered,
            "data"            => $result,
        ]);
    }

    public function reportMotor()
    {
        $motorModel = new MotorModel();

        $data = [
            'title' => 'Report',
            'submenu_title' => 'Report Motor',
            'motor' => $motorModel->findAll()
        ];
        return view('dashboard/motor-report', $data);
    }

    public function getMotorData()
    {
        $request = service('request');
        $motorModel = new MotorModel();

        // Ambil parameter dari DataTables
        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $searchValue = $request->getPost('search')['value'];

        // Query dasar
        $builder = $motorModel
            ->select('motors.*, brands.brand as brand_name, types.type as type_name')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('types', 'types.id = motors.id_type');

        // Hitung total data
        $recordsTotal = $builder->countAllResults(false);

        // Filter pencarian
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('motors.name', $searchValue)
                ->orLike('motors.number_plate', $searchValue)
                ->orLike('brands.brand', $searchValue)
                ->orLike('types.type', $searchValue)
                ->groupEnd();
        }

        // Hitung total data setelah filter
        $recordsFiltered = $builder->countAllResults(false);

        // Pagination
        if ($length != -1) {
            $builder->limit((int)$length, (int)$start);
        }

        // Ambil data
        $data = $builder->get()->getResult();

        // Format data untuk DataTables
        $rows = [];
        $no = $start + 1;

        foreach ($data as $item) {
            $rows[] = [
                $no++,
                $item->id,
                '<img src="' . base_url('uploads/motors/' . $item->photo) . '" width="60">',
                $item->brand_name . ' ' . $item->name,
                $item->number_plate,
                $item->type_name,
                "Rp " . number_format($item->price_per_day, 0, ',', '.'),
                $item->availability_status
            ];
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $rows
        ]);
    }

    public function exportMotorExcel()
    {
        $motorModel = new MotorModel();

        // Ambil semua data motor
        $motors = $motorModel
            ->select('motors.*, brands.brand as brand_name, types.type as type_name')
            ->join('brands', 'brands.id = motors.id_brand')
            ->join('types', 'types.id = motors.id_type')
            ->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'ID');
        $sheet->setCellValue('C1', 'Photo');
        $sheet->setCellValue('D1', 'Nama Motor');
        $sheet->setCellValue('E1', 'No Plat');
        $sheet->setCellValue('F1', 'Tipe');
        $sheet->setCellValue('G1', 'Price Per Day');
        $sheet->setCellValue('H1', 'Status');

        $row = 2;
        $no = 1;

        foreach ($motors as $m) {

            // Kolom teks biasa
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $m['id']);
            $sheet->setCellValue('D' . $row, $m['brand_name'] . ' ' . $m['name']);
            $sheet->setCellValue('E' . $row, $m['number_plate']);
            $sheet->setCellValue('F' . $row, $m['type_name']);
            $sheet->setCellValue('G' . $row, $m['price_per_day']);
            $sheet->setCellValue('H' . $row, $m['availability_status']);

            // ===== Add Image to Excel =====
            $photoPath = FCPATH . 'uploads/motors/' . $m['photo'];

            if (file_exists($photoPath)) {
                $drawing = new Drawing();
                $drawing->setPath($photoPath);
                $drawing->setWidth(60);
                $drawing->setHeight(60);
                $drawing->setCoordinates('C' . $row); // Column for photo
                $drawing->setOffsetX(5);
                $drawing->setWorksheet($sheet);
            }

            // Tinggikan baris agar foto muat
            $sheet->getRowDimension($row)->setRowHeight(50);
            $sheet->getColumnDimension('C')->setWidth(30);

            $row++;
        }

        // Auto-size kolom
        foreach (range('A', 'H') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Output file
        $filename = 'report_motor_' . date('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        // Set header untuk download
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment;filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($writer->save('php://output'));
    }

    public function reportUsers()
    {
        $userModel = new UserModel();

        $data = [
            'title' => 'Report',
            'submenu_title' => 'Report Users',
            'users' => $userModel->findAll()
        ];
        return view('dashboard/user-report', $data);
    }

    public function getUserData()
    {
        $request = service('request');
        $userModel = new UserModel();

        // DataTables parameters
        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $searchValue = $request->getPost('search')['value'];

        // Base query
        $builder = $userModel->select('id, username, full_name, email, phone, role, created_at');

        // Total records
        $recordsTotal = $builder->countAllResults(false);

        // Search filter
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('username', $searchValue)
                ->orLike('full_name', $searchValue)
                ->orLike('email', $searchValue)
                ->orLike('phone', $searchValue)
                ->orLike('role', $searchValue)
                ->groupEnd();
        }

        // Filtered records
        $recordsFiltered = $builder->countAllResults(false);

        // Pagination
        if ($length != -1) {
            $builder->limit((int)$length, (int)$start);
        }

        // Retrieve data
        $data = $builder->get()->getResult();

        // Format output
        $rows = [];
        $no = $start + 1;
        foreach ($data as $item) {

            $rows[] = [
                $no++,
                $item->username,
                $item->full_name,
                $item->email,
                $item->phone,
                ucfirst($item->role),
                date('d M Y', strtotime($item->created_at)),
            ];
        }

        // Return JSON for DataTables
        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $rows
        ]);
    }


    public function exportUserExcel()
    {
        $userModel = new UserModel();

        // Ambil semua data user
        $users = $userModel->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Full Name');
        $sheet->setCellValue('D1', 'Email');
        $sheet->setCellValue('E1', 'Phone');
        $sheet->setCellValue('F1', 'Role');
        $sheet->setCellValue('G1', 'Join Date');

        $row = 2;
        $no = 1;

        foreach ($users as $u) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $u['username']);
            $sheet->setCellValue('C' . $row, $u['full_name']);
            $sheet->setCellValue('D' . $row, $u['email']);
            $sheet->setCellValue('E' . $row, $u['phone']);
            $sheet->setCellValue('F' . $row, $u['role']);
            $sheet->setCellValue('G' . $row, date('d-m-Y', strtotime($u['created_at'])));

            $row++;
        }

        // Auto-size kolom
        foreach (range('A', 'G') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Output file
        $filename = 'report_users_' . date('Ymd_His') . '.xlsx';
        $writer = new Xlsx($spreadsheet);

        // Set header untuk download
        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment;filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($writer->save('php://output'));
    }
}
