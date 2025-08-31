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
            ],
            [
                'username'      => 'user',
                'email'         => 'user@mail.com',
                'password_hash' => password_hash('user123', PASSWORD_BCRYPT),
                'role'          => 'user',
            ],
            [
                'username'      => 'guest',
                'email'         => 'guest@mail.com',
                'password_hash' => password_hash('guest123', PASSWORD_BCRYPT),
                'role'          => 'guest',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
