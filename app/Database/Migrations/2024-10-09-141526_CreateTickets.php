<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTickets extends Migration
{
    public function up()
    {
       $this->forge->addField(
       	[
       		'id' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'unsigned' 		 => true,
       			'auto_increment' => true,
       		],

       		'raffle_id' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'unsigned' 		 => true,
       		],

       		'user_id' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'unsigned' 		 => true,
       		],

       		'status' => [
       			'type' 			 => 'TINYINT',
       			'constraint' 	 => 1,
       			'default' 		 => 0, //valor inicial
       			'COMMENT' 		 => '0 => Reservado, 1 => Pago',
       		],

       		'payment_method' => [
       			'type' 			 => 'VARCHAR',
       			'constraint' 	 => 30,
       		],

       		'created_at' => [
       			'type' 			 => 'DATETIME',
       			'null'			 => true,
       			'default'		 => null,
       		],

       		'updated_at' => [
       			'type' 			 => 'DATETIME',
       			'null'			 => true,
       			'default'		 => null,
       		],

        ]
   		);

       $this->forge->addKey('id', true);
       $this->forge->addKey('raffle_id');
       $this->forge->addKey('user_id');

       $this->forge->addForeignKey('raffle_id', 'raffles', 'id', 'CASCADE', 'CASCADE');
       $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

       $this->forge->createTable('tickets');

    }

    public function down()
    {
        $this->forge->dropTable('tickets');
    }
}
