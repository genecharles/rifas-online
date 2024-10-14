<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Entities\Prize;
use App\Entities\Raffle;

class RafflePrizeModel extends AppModel
{
    protected $table            = 'raffles_prizes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'raffle_id',
        'prize_id',
    ];

    

   public function getByRafflesIds(array $rafflesIds): array{
        $this->select([
            'prizes.*', //quero tudo de prizes
            'raffles_prizes.raffle_id', // usaremos em diverso locais do codigo
        ]);
        //unir nessa consulta
        $this->join('prizes', 'prizes.id = raffles_prizes.prize_id');

        $this->whereIn('raffles_prizes.raffle_id', $rafflesIds);
        $this->asObject(Prize::class);

        return $this->findAll();


   }

   public function getByPrizesIds(array $prizesIds): array{
        $this->select([
            'raffles.*', //quero tudo de rifas
            'raffles_prizes.prize_id', // usaremos em diverso locais do codigo
        ]);
        //unir nessa consulta
        $this->join('raffles', 'raffles.id = raffles_prizes.raffle_id');
        $this->whereIn('raffles_prizes.prize_id', $prizesIds);
        $this->asObject(Raffle::class);

        return $this->findAll();
   }
    
}
