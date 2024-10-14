<?php

namespace App\Models;

use App\Entities\Winner;
use App\Models\Basic\AppModel;

class WinnerModel extends AppModel
{
    protected $table            = 'winners';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Winner::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'raffle_id',
        'user_id',
        'winning_number',
    ];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    
    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['escapeData'];
    protected $beforeUpdate   = ['escapeData'];
}
