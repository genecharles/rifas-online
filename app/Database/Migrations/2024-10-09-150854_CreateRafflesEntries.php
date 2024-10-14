<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRafflesEntries extends Migration
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

       		'ticket_id' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'unsigned' 		 => true,
       		],

       		'user_id' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'unsigned' 		 => true,
       		],

       		'number' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'comment' 		 => 'Número escolhido',
       		],

        ]
   		);

       $this->forge->addKey('id', true);
       $this->forge->addKey('raffle_id');
       $this->forge->addKey('ticket_id');
       $this->forge->addKey('user_id');
       $this->forge->addKey('number');

       $this->forge->addForeignKey('raffle_id', 'raffles', 'id', 'CASCADE', 'CASCADE');
       $this->forge->addForeignKey('ticket_id', 'tickets', 'id', 'CASCADE', 'CASCADE');
       $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');

       $this->forge->createTable('raffles_entries');

    }

    public function down()
    {
        $this->forge->dropTable('raffles_entries');
    }
}
