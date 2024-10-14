<?php

namespace App\Validation;

class RaffleValidation
{
    public function getRules(): array
     {
         return [

         	'title' => [
         		'rules' => 'required|max_length[128]',
         		'errors' => [
         			'required' => 'Informe o titulo'
         		],
         	],

         	'price' => [
         		'rules' => 'required'
         	],

         	'total_tickets' => [
         		'rules' => 'required'
         	],

         	'draw_date' => [
         		'rules' => 'required'
         	],

         	'description' => [
         		'rules' => 'required'
         	],
         	
         ];
     }
}
