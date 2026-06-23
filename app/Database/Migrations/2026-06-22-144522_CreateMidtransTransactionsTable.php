<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMidtransTransactionsTable extends Migration
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
            'id_sewa' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'id_user' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'order_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true, // order_id used for midtrans
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'payment_type' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'snap_token' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'transaction_status' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'default'    => 'pending',
            ],
            'midtrans_transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        
        // Foreign keys to preserve data integrity (assuming existing tables match)
        $this->forge->addForeignKey('id_sewa', 'penyewaan', 'id_sewa', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('midtrans_transactions');
    }

    public function down()
    {
        $this->forge->dropTable('midtrans_transactions');
    }
}
