<?php

namespace App\Models;

use App\Entities\Ticket;
use App\Models\Basic\AppModel;

class TicketModel extends AppModel
{
    protected $table            = 'tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Ticket::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'raffle_id',
        'user_id',
        'payment_method',
        'status',
    ];

    

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['setUserId', 'escapeData'];
    protected $beforeUpdate   = ['escapeData'];

    protected function setUserId(array $data): array{

        if (!isset($data['data'])) {
            return $data;
        }

        $data['data']['user_id'] = auth()->user()->id;

        return $data;
    }
}
