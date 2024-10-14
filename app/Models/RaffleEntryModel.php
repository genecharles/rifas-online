<?php

namespace App\Models;

use App\Models\Basic\AppModel;
use App\Entities\RaffleEntry;
use CodeIgniter\Model;

class RaffleEntryModel extends AppModel
{
    protected $table            = 'raffles_entries';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = RaffleEntry::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'raffle_id',
        'ticket_id',
        'user_id',
        'number',
    ];


    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData'];
    protected $beforeUpdate   = ['escapeData'];
}
