<?php
declare(strict_types=1);

namespace App\Libraries\Raffle;

use App\Models\RaffleModel;
use App\Models\RafflePrizeModel;
use App\entities\Raffle;
use CodeIgniter\I18n\Time;
/**
 * 
 */
class ListService {
	
	private RaffleModel $builder;

	public function __construct()
	{
		$this->builder = model(RaffleModel::class);
		$this->setWhere();
	}

	public function all(): array{

		$raffles = $this->builder->orderBy('id','DESC')->findAll();

		if (empty($raffles)) {
			return [];
		}

		$rafflesIds = array_column($raffles, 'id');

		$prizes = model(RafflePrizeModel::class)->getByRafflesIds(rafflesIds:$rafflesIds);

		foreach ($raffles as $raffle) {
			$raffle->prizes = array_filter($prizes, function($prize) use ($raffle){
				return (int) $prize->raffle_id === (int) $raffle->id;
			});
		}

		return $raffles;

	}

	public function single(string $code): Raffle{

		$raffle = $this->builder->where(['code' => $code])->first();

		if ($raffle === null) {

			throw new PageNotFoundException("A rifa código {$code} não foi localizada");
			
		}

		$raffle->prizes = model(RafflePrizeModel::class)->getByRafflesIds(rafflesIds: [$raffle->id]);

		return $raffle;
	}

	private function setWhere(): void{
		//hoje
		$today = Time::now()->format('Y-m-d');
		// quero apenas com tickets disponiveis
		$this->builder->where('total_tickets > sold_tickets');

		//que ainda nao foi sorteado
		$this->builder->where('winning_number', null);

		//valores ainda nao repassado para o criador da rifa
		$this->builder->where('values_transferred', 0);

		//onde a data de sorteio seja maior que a data atual
		//pois nao queremos q o user compre numeros no exato momento em que o sorteio ocorrerá
		$this->builder->where('draw_date >', $today);

		//apenas rifas que tem premios associados
		$this->builder->whereIn('id', function($builder){
			$builder->select('raffle_id')->from('raffles_prizes');
		});
	}
}
?>