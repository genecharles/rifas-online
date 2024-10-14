<?php

namespace App\Models\Basic;

use CodeIgniter\Model;

abstract class AppModel extends Model
{

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = false; // para nao dar erro de dados sem alteração

    protected array $casts = [];
    protected array $castHandlers = [];

    protected function escapeData(array $data):array {
        return esc($data);
    }

    protected function setCode(array $data):array {
        if (! isset($data['data'])) {
            return $data;
        }

        do {
            $lenght = 50; // cuidado com o tamanno da coluna na migraçao
            $characters = '0123456789';
            $code = '';

            for ($i=0; $i < $lenght; $i++) { 
               $code .= $characters[ random_int(0, strlen($characters)- 1) ];
            }

        } while ($this->select('code')->where(['code' => $code])->countAllResults() > 0);
        $data['data']['code'] = $code;

        return $data;
        
    }

    protected function setCreatorId(array $data): array{

        if (!isset($data['data'])) {
            return $data;
        }

        $data['data']['creator_id'] = auth()->user()->id;

        return $data;
    }


    public function whereCreator(): self{

        $this->where(["{$this->table}.creator_id" => auth()->user()->id]);

        return $this;
    }

}
