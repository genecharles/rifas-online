<?php
declare(strict_types=1);

namespace App\Libraries\Raffle;

use App\Entities\Raffle;
use App\Models\RaffleEntryModel;

class AvailableNumbersService 
{
	
	//recupera os numeros que estao comprados / reservados
	public function get(Raffle $raffle):array {
		$lockedNumbers = model(RaffleEntryModel::class)
					->select('number')
					->where('raffle_id', $raffle->id)
					->orderBy('number', 'ASC')
					->findAll();

	// receberá ps numeros disponiveis
	$availabesNumbers = [];

	for ($number = 1; $number <= $raffle->total_tickets; $number++) { 

		if (!in_array($number, array_column($lockedNumbers, 'number'))) {
			$availabesNumbers[] = $number;
		}
		
	}

	return $availabesNumbers;


	}


}
?>