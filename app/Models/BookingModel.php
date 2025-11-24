<?php

namespace App\Models;

use CodeIgniter\Model;

class BookingModel extends Model
{
    protected $table            = 'bookings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'motor_id', 'rental_start_date', 'rental_end_date', 'total_price', 'status', 'identity_photo', 'notes'];

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

    public function getBookingsByUser($userId)
    {
        return $this->where('user_id', $userId)->findAll();
    }

    public function getBookingDetails($bookingId)
    {
        return $this->select('bookings.*, users.full_name, users.email, users.phone, motors.brand_name, motors.motor_name, motors.number_plate, motors.price_per_day')
            ->join('users', 'users.id = bookings.user_id')
            ->join('motors', 'motors.id = bookings.motor_id')
            ->where('bookings.id', $bookingId)
            ->first();
    }
}
