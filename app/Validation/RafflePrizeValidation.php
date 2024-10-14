<?php

namespace App\Validation;

class RafflePrizeValidation
{
    public function getRules(): array
     {
         return [

         	'prizes' => [
         		'rules' => 'required',
         		'errors' => [
         			'required' => 'Escolha pelo menos um prêmio'
         		],
         	],
         	
         ];
     }
}
