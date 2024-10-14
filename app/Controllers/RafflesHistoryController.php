<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\RaffleHistory\ListService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;


class RafflesHistoryController extends BaseController
{

	private const VIEWS_DIRECTORY = 'RafflesHistory/';

	private ListService $listService;

	public function __construct()
	{
		$this->listService = new ListService;
	}


    public function index()
    {
        $data = [
        	'title' => 'Meu histórico de compras',
        	'raffles' => $this->listService->all(),
        ];

        return view(self::VIEWS_DIRECTORY . 'index', $data);
    }

    


    public function show(string $code)
    {
        $data = [
        	'title' => 'Detalhes da Rifa',
        	'raffle' => $this->listService->single(code: $code),
        ];

        return view(self::VIEWS_DIRECTORY . 'show', $data);
    }

 
}
