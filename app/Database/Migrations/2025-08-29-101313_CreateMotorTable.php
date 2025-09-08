<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMotorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'id_brand' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_type' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'price_per_day' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'availability_status' => [
                'type'       => 'ENUM',
                'constraint' => ['available', 'rented', 'maintenance'],
                'default'    => 'available',
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
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
        $this->forge->createTable('motors');
        $this->forge->addForeignKey('id_brand', 'brands', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_type', 'types', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        //
        $this->forge->dropTable('motors');
    }
}
