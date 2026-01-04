<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMotorLogbookTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'motor_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'booking_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => ['check-in', 'check-out'],
            ],
            'condition_note' => [
                'type' => 'TEXT',
            ],
            'fuel_level' => [
                'type' => 'VARCHAR',
                'constraint' => 11,
            ],
            'photo' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('motor_logbooks');
    }

    public function down()
    {
        //
        $this->forge->dropTable('motor_logbooks');
    }
}
