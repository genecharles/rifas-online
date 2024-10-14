<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Ticket extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
    	'status' => 'boolean'
    ];

    public function status(): string{

    	return $this->status ? 'Pago' : 'Reservado';
    	
    }
}
