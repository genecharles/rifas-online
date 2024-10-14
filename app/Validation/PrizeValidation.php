<?php

namespace App\Validation;

class PrizeValidation
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

            'image_url' => [
                'rules' => 'required|valid_url|max_length[255]',
                'errors' => [
                    'required' => 'Informe a URL da imagem'
                ],
            ],

         	'description' => [
         		'rules' => 'required'
         	],
         	
         ];
     }
}
