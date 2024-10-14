<?php
use App\Controllers\HomeController;
use App\Controllers\RafflesController;
use App\Controllers\PrizesController;
use App\Controllers\RafflesPrizesController;
use App\Controllers\RafflesTicketsController;
use App\Controllers\RafflesHistoryController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', [HomeController::class, 'index'], ['as' => 'home']);

//auth de autenticação
service('auth')->routes($routes);

$routes->group('raffles',['filter' => 'session'], static function($routes){

	$routes->get('/', [RafflesController::class, 'index'], ['as' => 'raffles']);	
	$routes->get('new', [RafflesController::class, 'new'], ['as' => 'raffles.new']);
	$routes->get('show/(:segment)', [RafflesController::class, 'show/$1'], ['as' => 'raffles.show']);
	$routes->delete('destroy/(:segment)', [RafflesController::class, 'destroy/$1'], ['as' => 'raffles.destroy']);
	$routes->post('create', [RafflesController::class, 'create'], ['as' => 'raffles.create']);


	$routes->group('prizes',['filter' => 'session'], static function($routes){

		$routes->get('manage/(:segment)', [RafflesPrizesController::class, 'manage/$1'], ['as' => 'raffles.prizes']);
		$routes->put('store/(:segment)', [RafflesPrizesController::class, 'store/$1'], ['as' => 'raffles.prizes.store']);
		
	});

});


$routes->group('tickets', static function($routes){

	$routes->get('display/(:segment)', [RafflesTicketsController::class, 'display/$1'], ['as' => 'tickets']);
	$routes->post('reserve-number', [RafflesTicketsController::class, 'reserveNumbers'], ['as' => 'tickets.reserve.numbers']);

	//rota de confiração precisa estar autenticado
	$routes->get('confirm/(:segment)', [RafflesTicketsController::class, 'confirm/$1'], ['as' => 'tickets.confirm', 'filter' => 'session']);

	$routes->post('pay/(:segment)', [RafflesTicketsController::class, 'pay/$1'], ['as' => 'tickets.pay.numbers', 'filter' => 'session']);
	
});



$routes->group('history',['filter' => 'session'], static function($routes){

	$routes->get('/', [RafflesHistoryController::class, 'index'], ['as' => 'history']);
	$routes->get('show/(:segment)', [RafflesHistoryController::class, 'show/$1'], ['as' => 'history.show']);	
	
});