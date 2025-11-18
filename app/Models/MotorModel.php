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

    public function isMotorAvailable($motorId, $startDate, $endDate)
    {
        $conflict = $this->db->table('bookings')
            ->where('motor_id', $motorId)
            ->where('status !=', 'canceled')
            ->where('rental_start_date <=', $endDate)
            ->where('rental_end_date >=', $startDate)
            ->get()
            ->getRowArray();

        return $conflict ? false : true;
    }
}
