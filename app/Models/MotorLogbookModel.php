<?php

namespace App\Models;

use CodeIgniter\Model;

class MotorLogbookModel extends Model
{
    protected $table            = 'motor_logbooks';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['kode', 'motor_id', 'user_id', 'booking_id', 'type', 'fuel_level', 'photo', 'condition_note', 'created_at', 'updated_at'];

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

    public function getMotorLogbook($motorId)
    {
        return $this->where('motor_id', $motorId)->findAll();
    }

    public function isMotorAvailable($motorId)
    {
        $latestLog = $this->where('motor_id', $motorId)
            ->orderBy('created_at', 'DESC')
            ->first();

        // Jika tidak ada log, motor tersedia (belum pernah di-checkout)
        if (!$latestLog) {
            return true;
        }

        // Motor tersedia jika log terakhir adalah check-in
        // Jadi motor TIDAK tersedia jika log terakhir adalah check-out
        return $latestLog['type'] === 'check-in';
    }

    /**
     * Get latest log for a motor
     */
    public function getLatestLog($motorId)
    {
        return $this->where('motor_id', $motorId)
            ->orderBy('created_at', 'DESC')
            ->first();
    }
}
