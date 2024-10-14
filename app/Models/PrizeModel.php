<?php

namespace App\Models;

use App\Entities\Prize;
use App\Models\Basic\AppModel;


class PrizeModel extends AppModel
{
    protected $table            = 'prizes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Prize::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'creator_id',
        'title',
        'image_url',
        'description',
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

    public function getByCode(string $code, bool $withRaffles = false): Prize 
    {

        $prize = $this->whereCreator()->where(['code' => $code])->first();

        if ($prize === null) {
            
           throw new PageNotFoundException("Não encontramos o seu prêmio código: {$code}");
        }

        if ($withRaffles) {
            
            $prize->raffles = model(RafflePrizeModel::class)->getByPrizesIds([$prize->id]);
        }

        return $prize;

    }
}
