<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'      => 'admin',
                'email'         => 'admin@mail.com',
                'password_hash' => password_hash('admin123', PASSWORD_BCRYPT),
                'role'          => 'admin',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'user',
                'email'         => 'user@mail.com',
                'password_hash' => password_hash('user123', PASSWORD_BCRYPT),
                'role'          => 'user',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'guest',
                'email'         => 'guest@mail.com',
                'password_hash' => password_hash('guest123', PASSWORD_BCRYPT),
                'role'          => 'guest',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'username'      => 'owner',
                'email'         => 'owner@mail.com',
                'password_hash' => password_hash('owner123', PASSWORD_BCRYPT),
                'role'          => 'owner',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],

        ];

        $this->db->table('users')->insertBatch($data);
    }
}
