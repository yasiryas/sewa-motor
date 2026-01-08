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
    protected $allowedFields    = ['motor_id', 'user_id', 'booking_id', 'type', 'condition_note', 'created_at', 'updated_at'];

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

    private function isMotorAvailable($motorId)
    {
        $latestLog = $this->where('motor_id', $motorId)
            ->orderBy('created_at', 'DESC')
            ->first();

        if ($latestLog) {
            return $latestLog['type'] === 'check-out';
        }

        return true; // Jika tidak ada log, motor dianggap tersedia
    }
}
