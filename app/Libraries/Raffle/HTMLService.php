<?php
declare(strict_types=1);

namespace App\Libraries\Raffle;

use CodeIgniter\View\Table;
use App\Enum\Payment\Methods;

/**
 * 
 */
class HTMLService {
	
	public function listPrizes(array $prizes, bool $showRoute = true): string {

		if (empty($prizes)) {
			return 'Não há dados para exibir';
		}

		$html = '<ul class="list-group list-group-horizontal">';

		foreach ($prizes as $prize) {

			if (!$showRoute) {//$showRoute
				
				$image = $prize->imageUrl(width: 250);
			}else{
				$image = anchor(
					uri: route_to('prizes.show', $prize->code),
					title: $prize->imageUrl(width:100),
					attributes: [
						'class' => 'btn btn-link', 
						'title' => 'Gerenciar {$prize->title}',
						'target' => '_blank'
				]);
			}

			$image .= "<p class='text-center'>{$prize->title}</p>";
			$html .= "<li class='list-group-item border-0 text-center'>{$image}</li>";
		}

		$html .='</ul>';


		return $html;
	}

	public function tableTickets(array $tickets): string{

		if (empty($tickets)) {
			
			return 'Não há dados para exibir';

		}

		$table = new Table();
		$table->setTemplate([
			'table_open' => '<table class="table table-sm table-borderless">'

		]);

		$table->setHeading([
			'Data da compra', 'Forma de pagamento', 'Status', 'Números escolhidos'
		]);

		foreach ($tickets as $ticket) {
			
			$table->addRow([
				$ticket->created_at,
				Methods::from($ticket->payment_method)->label(),
				$ticket->status(),
				implode(', ', array_column($ticket->numbers, 'number')),
			]);
		}


		return $table->generate();
	}
}
?>