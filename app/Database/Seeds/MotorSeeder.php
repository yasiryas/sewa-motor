<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MotorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'                => 'Yamaha NMAX',
                'brand'               => 'Yamaha',
                'price_per_day'       => 150000,
                'availability_status' => 'available',
                'photo'               => 'nmax.jpg',
            ],
            [
                'name'                => 'Honda Vario',
                'brand'               => 'Honda',
                'price_per_day'       => 120000,
                'availability_status' => 'available',
                'photo'               => 'vario.jpg',
            ],
            [
                'name'                => 'Suzuki Address',
                'brand'               => 'Suzuki',
                'price_per_day'       => 100000,
                'availability_status' => 'maintenance',
                'photo'               => 'address.jpg',
            ],
        ];

        $this->db->table('motors')->insertBatch($data);
    }
}
