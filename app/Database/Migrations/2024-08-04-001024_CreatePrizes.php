<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePrizes extends Migration
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

       		'image_url' => [
       			'type' 			 => 'VARCHAR',
       			'constraint' 	 => 255,
       			'COMMENT' => 'Imagem do prêmio',
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
       $this->forge->addKey('creator_id');
       $this->forge->addKey('code');
       $this->forge->addKey('title');
       $this->forge->addKey('created_at');
       $this->forge->addKey('updated_at');

       $this->forge->addForeignKey('creator_id', 'users', 'id', 'CASCADE', 'CASCADE');

       $this->forge->createTable('prizes');

    }

    public function down()
    {
        $this->forge->dropTable('prizes');
    }
}
