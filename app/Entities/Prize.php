<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Prize extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at'];
    protected $casts   = [];

    public function imageUrl(int $width = 200): string
    {

    	return empty($this->image_url) 
    	? 'Não definada'
    	: img(src: $this->image_url, attributes: ['class' => 'img-fluid img-thumbnail', 'width' => $width]);
    }

    public function raffles(): string{

        if (empty($this->raffles)) {
           return 'Não há dados para exibir';
        }
        
        $list = [];

        foreach($this->raffles as $raffle) {
            $list[] = $raffle->title;
        }

    	return ul($list);
    }
}
