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
    protected $allowedFields    = ['name', 'number_plate', 'id_brand', 'id_type', 'brand', 'price_per_day', 'availability_status', 'photo'];

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
        return $this->where('availability_status', 'available')->findAll();
    }

    public function getAvialableMotorsBooking($start_date, $end_date)
    {
        // $subquery = $this->db->table('bookings')
        //     ->select('motor_id')
        //     ->where('status !=', 'canceled')
        //     ->groupStart()
        //     ->where('rental_start_date <=', $end_date)
        //     ->where('rental_end_date >=', $start_date)
        //     ->groupEnd()
        //     ->getCompiledSelect();

        // return $this->db->table('motors')
        //     ->where('availability_status', 'available')
        //     ->where("id NOT IN ($subquery)")
        //     ->get()
        //     ->getResultArray();

        return $this->db->table('motors')
            ->where('availability_status', 'available')
            ->whereNotIn('id', function ($builder) use ($start_date, $end_date) {
                return $builder->select('motor_id')
                    ->from('bookings')
                    ->where('status !=', 'canceled')
                    ->groupStart()
                    ->where('rental_start_date <=', $end_date)
                    ->where('rental_end_date >=', $start_date)
                    ->groupEnd();
            })
            ->get()
            ->getResultArray();
    }
}
