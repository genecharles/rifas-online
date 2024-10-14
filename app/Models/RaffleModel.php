<?php

namespace App\Models;

use App\Entities\Raffle;
use App\Models\Basic\AppModel;
use App\Models\RafflePrizeModel;

class RaffleModel extends AppModel
{
    protected $table            = 'raffles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Raffle::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'creator_id',
            'title',
            'description',
            'price',
            'total_tickets',
            'sold_tickets',
            'draw_date',
            'winning_number',
            'values_transferred',
    ];

    

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData', 'setCode', 'setCreatorId'];
    protected $beforeUpdate   = ['escapeData'];

    public function all(): array {

        return $this->whereCreator()->orderBy('created_at', 'DESC')->findAll();
    }

    public function getByCode(string $code, bool $withPrizes = false): Raffle {

        $raffle = $this->whereCreator()->where(['code' => $code])->first();

        if ($raffle === null) {
           throw new PageNotFoundException("Não encontramos a sua rifa código: {$code}");
        }

        if ($withPrizes) {
           $raffle->prizes = model(RafflePrizeModel::class)->getByRafflesIds([$raffle->id]);
        }

        return $raffle;

    }
    
}
