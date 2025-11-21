<?php

namespace App\Models;

use CodeIgniter\Model;

class MotorModel extends Model
{
    protected $table            = 'motors';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'number_plate', 'id_brand', 'id_type', 'brand', 'price_per_day', 'availability_status', 'description', 'photo'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getAvailableMotors()
    {
        return $this->where('availability_status', 'available')->findAll(8, 0);
    }

    public function getAvialableMotorsBooking($start_date, $end_date)
    {
        if (empty($start_date) || empty($end_date)) {
            return []; // jangan query kalau tanggal kosong
        }

        return $this->db->table('motors m')
            ->select('m.*')
            ->where('m.availability_status', 'available')
            ->join(
                'bookings b',
                "b.motor_id = m.id
         AND b.status != 'canceled'
         AND b.rental_start_date <= " . $this->db->escape($end_date) . "
         AND b.rental_end_date >= " . $this->db->escape($start_date),
                'left'
            )
            ->where('b.motor_id IS NULL')
            ->get()
            ->getResultArray();
    }

    public function getAvialableMotorsBookingSearch($start_date, $end_date)
    {
        if (empty($start_date) || empty($end_date)) {
            return $this->response->setJSON([]);
        }

        $keyword = $this->request->getGet('q'); // keyword dari client

        $builder = $this->db->table('motors m')
            ->select('m.*')
            ->where('m.availability_status', 'available')
            ->join(
                'bookings b',
                "b.motor_id = m.id
             AND b.status != 'canceled'
             AND b.rental_start_date <= " . $this->db->escape($end_date) . "
             AND b.rental_end_date >= " . $this->db->escape($start_date),
                'left'
            )
            ->where('b.motor_id IS NULL');

        if (!empty($keyword)) {
            $builder->like('m.name', $keyword); // filter berdasarkan nama motor
        }

        $motors = $builder->get()->getResultArray();
        return $this->response->setJSON($motors);
    }

    public function isMotorAvailable($motorId, $startDate, $endDate, $excludeBookingId = null)
    {
        $query = $this->db->table('bookings')
            ->select('bookings.*', 'users.name as user_name', 'users.email as user_email', 'users.phone as user_phone')
            ->join('users', 'bookings.user_id = users.id')
            ->where('motor_id', $motorId)
            ->where('status !=', 'canceled')
            ->where('rental_start_date <=', $endDate)
            ->where('rental_end_date >=', $startDate);

        if ($excludeBookingId) {
            $query->where('bookings.id !=', $excludeBookingId);
        }

        $conflict = $query->get()->getRowArray();

        if ($conflict) {
            $message = "Motor sudah dibooking oleh " . ($conflict['username'] ?? 'Customer') .
                " pada tanggal " . date('d F Y', strtotime($conflict['rental_start_date'])) .
                " hingga " . date('d F Y', strtotime($conflict['rental_end_date'])) .
                ". Silakan pilih tanggal lain.";
            return [
                'available' => false,
                'conflict_data' => $conflict,
                'message' => $message
            ]; // motor tidak tersedia
        }
        return [
            'available' => true,
            'conflict_data' => null,
            'message' => 'Motor is available for the selected dates.'
        ]; // motor tersedia
    }

    private function genrateConflictMessage($conflict)
    {
        $startDate = date('d M Y', strtotime($conflict['rental_start_date']));
        $endDate = date('d M Y', strtotime($conflict['rental_end_date']));
        $username = $conflict['user_name'] ?? ' Customer ';

        return "Ups, Motor sudah terbooking oleh <b>{$username}</b> dari tanggal <b>{$startDate}</b> sampai <b>{$endDate}</b>. Silakan pilih tanggal lain.";
    }
}
