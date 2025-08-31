<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookingTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'motor_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rental_start_date' => [
                'type' => 'DATE',
            ],
            'rental_end_date' => [
                'type' => 'DATE',
            ],
            'total_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'confirmed', 'canceled', 'completed'],
                'default'    => 'pending',
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('motor_id', 'motors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('bookings');
    }

    public function down()
    {
        //
        $this->forge->dropTable('bookings');
    }
}
