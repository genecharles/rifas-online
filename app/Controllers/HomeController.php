<?php

namespace App\Controllers;
use App\Libraries\Raffle\ListService;

class HomeController extends BaseController
{
	private const VIEWS_DIRECTORY = 'Home/';

    public function index(): string
    {
    	$data = [
    		'title' => 'Home',
    		'raffles' => (new ListService)->all(),
    	];
        return view(self::VIEWS_DIRECTORY . 'index', $data);
    }
}
