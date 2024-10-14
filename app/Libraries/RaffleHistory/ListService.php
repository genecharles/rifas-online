<?php
declare(strict_types=1);

namespace App\Libraries\RaffleHistory;

use App\Models\RaffleModel;
use App\Models\RafflePrizeModel;
use App\Models\WinnerModel;
use App\Models\TicketModel;
use App\Models\RaffleEntryModel;
use App\Entities\Raffle;

class ListService{

	private RaffleModel $builder;

	public function __construct()
	{
		$this->builder = model(RaffleModel::class);

		$this->setWhere();
	}

	public function all(): array {

		return $this->builder->findAll();
	}

	public function single(string $code): Raffle{

		$raffle = $this->builder->where(['code' => $code])->first();

		if (!$raffle === null) {

			throw new PageNotFoundException("Sua rifa código {$code} não foi localizada");
			
		}

		$loggedUser = auth()->user();

		$raffle->prizes = model(RafflePrizeModel::class)->getByRafflesIds(rafflesIds: [$raffle->id]);

		//identificamos se essa é uma rifa premiada
		//ver se a rifa é premiada ou nao
		$raffle->winning_raffle = model(WinnerModel::class)->where([
			'raffle_id' => $raffle->id, 'user_id' => $loggedUser->id
		])->first() !== null;

		//recupera os tickets da rifa e do user logado
		//lembre que o user pode realizar varias comprar para uma mesma rifa
		$tickets = model(TicketModel::class)->where([
			'raffle_id' => $raffle->id, 'user_id' => $loggedUser->id
		])->findAll();

		//recupera os nrs associado aos tikets, rifa e usr logado
		$numbers = model(RaffleEntryModel::class)
			->whereIn('ticket_id', array_column($tickets, 'id')) //de acordo com os ids dos tickets da rifa e do user logado
			->where([
				'raffle_id' => $raffle->id, // da rifa
				'user_id' => $loggedUser->id,//do user logado
			])->orderBy('number', 'ASC')->findAll();


			//para cada ticket eu associo os nr comprados
			foreach ($tickets as $ticket) {

				$ticket->numbers = array_filter($numbers, function($number) use($ticket){

					return (int)$ticket->id === (int)$number->ticket_id;
					
				});
			}

			//associo os tiket as rifas
			$raffle->tickets = $tickets;

			//retornamos a rifa
			return $raffle;

	}

	private function setWhere(): void{

		//apenas as rifas que estao associados ao usuario logado
		$this->builder->whereIn('id', function($builder){
			$builder->select('raffle_id')->from('tickets')->where('user_id', auth()->user()->id);
		});


	}
}

?>