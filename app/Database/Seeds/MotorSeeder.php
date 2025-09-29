<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MotorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Honda Beat',
                'number_plate' => 'B 1234 AB',
                'price_per_day' => 100000,
                'photo' => 'beat.jpg',
                'availability_status' => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Honda Vario',
                'number_plate' => 'B 1234 BC',
                'price_per_day' => 120000,
                'photo' => 'vario.jpg',
                'availability_status' => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Yamaha Nmax',
                'number_plate' => 'B 1234 CD',
                'price_per_day' => 150000,
                'photo' => 'nmax.jpg',
                'availability_status' => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Yamaha Aerox',
                'number_plate' => 'B 1234 DE',
                'price_per_day' => 130000,
                'photo' => 'aerox.jpg',
                'availability_status' => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Suzuki Nex',
                'number_plate' => 'B 1234 EF',
                'price_per_day' => 90000,
                'photo' => 'nex.jpg',
                'availability_status' => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Suzuki Address',
                'number_plate' => 'B 1234 FG',
                'price_per_day' => 95000,
                'photo' => 'address.jpg',
                'availability_status' => 'available',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('motors')->insertBatch($data);
    }
}
