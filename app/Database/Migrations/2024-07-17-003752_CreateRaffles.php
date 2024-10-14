<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRaffles extends Migration
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

       		'creator_id' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'unsigned' 		 => true,
       			'COMMENT' => 'Identificador do usuario logado',
       		],

       		'code' => [
       			'type' 			 => 'VARCHAR',
       			'constraint' 	 => 15,
       		],

       		'title' => [
       			'type' 			 => 'VARCHAR',
       			'constraint' 	 => 128,
       		],

       		'description' => [
       			'type' 			 => 'TEXT',
       			'constraint' 	 => 2000,
       		],

       		'price' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'COMMENT' => 'Preço de cada número / bilhete',
       		],

       		'total_tickets' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'COMMENT' => 'Total de bilhetes disponíveis',
       		],

       		'sold_tickets' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'COMMENT' => 'Total de bilhetes vendidos',
       		],

       		'draw_date' => [
       			'type' 		 => 'DATE',
       			'COMMENT'	 => 'Data do sorteio',
       		],

       		'winning_number' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 11,
       			'null'			 => true,
       			'default'		 => null,
       			'COMMENT'		 => 'Receberá o número vencedor',
       		],

       		'values_transferred' => [
       			'type' 			 => 'INT',
       			'constraint' 	 => 1,
       			'default'		 => 0,// inicialmente não
       			'COMMENT'		 => '0 => Valores não transferidos, 1 => Valores transferidos',
       		],

       		'created_at' => [
       			'type' 			 => 'DATETIME',
       			'null'			 => true,
       			'default'		 => null,
       		],

       		'update_at' => [
       			'type' 			 => 'DATETIME',
       			'null'			 => true,
       			'default'		 => null,
       		],

        ]
   		);

       $this->forge->addKey('id', true);
       $this->forge->addKey('creator_id');
       $this->forge->addKey('code');
       $this->forge->addKey('title');
       $this->forge->addKey('total_tickets');
       $this->forge->addKey('sold_tickets');
       $this->forge->addKey('draw_date');
       $this->forge->addKey('price');
       $this->forge->addKey('winning_number');
       $this->forge->addKey('values_transferred');
       $this->forge->addKey('created_at');
       $this->forge->addKey('update_at');

       $this->forge->addForeignKey('creator_id', 'users', 'id', 'CASCADE', 'CASCADE');

       $this->forge->createTable('raffles');

    }

    public function down()
    {
        $this->forge->dropTable('raffles');
    }
}
