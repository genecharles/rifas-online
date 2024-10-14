<?php
declare(strict_types=1);

namespace App\Libraries\Ticket;

use App\Entities\Raffle;
use App\Entities\RaffleEntry;
use App\Entities\Ticket;
use App\Models\RaffleModel;
use App\Models\TicketModel;
use App\Models\RaffleEntryModel;

class StoreService{

	private TicketModel $ticketModel;
	private Raffle $raffle;
	private string $paymentMethod;
	private array $chosenNumbers;

	public function __construct(Raffle $raffle, string $paymentMethod, array $chosenNumbers)
	{
		$this->ticketModel = model(TicketModel::class);
		$this->raffle = $raffle;
		$this->paymentMethod = $paymentMethod;
		$this->chosenNumbers = $chosenNumbers;
	}

	public function execute(): bool{
		
		try {

			$this->ticketModel->db->transException(true)->transStart();

			//criar o ticket
			$ticketId = $this->ticketModel->insert(new Ticket([
				'raffle_id' => $this->raffle->id,
				'payment_method' => $this->paymentMethod,
				'status' => 1, //esc olhi deixar como pago. o aluno nessa altura ja consegue implementar uma maneira de identificar quando ela deve deixar reservado como pago
			]));

			//armazenamos os numeros
			model(RaffleEntryModel::class)->insertBatch($this->prepareNumers(ticketId: $ticketId));

			//incrementaos o numero de tickets vendido da rifa
			$this->raffle->sold_tickets += count($this->chosenNumbers);

			//atualizadmo o sold_ticekt da rifa
			model(RaffleModel::class)->save($this->raffle);

			//fecho a minha transaction
			$this->ticketModel->db->transComplete();

			//retorno o resultado
			return $this->ticketModel->db->transStatus();
			
		} catch (\Throwable $th) {
			log_message('error', '[ERROR] {exception}', ['exception' => $th]);
			return false;
		}
	}

	private function prepareNumers(int $ticketId): array {
		//id do ususario logado
		$userId = user_id();

		$dataProvider = [];

		foreach ($this->chosenNumbers as $number) {

			$dataProvider[] = new RaffleEntry([
				'raffle_id' => $this->raffle->id,
				'ticket_id' => $ticketId,
				'user_id' => $userId,
				'number' => $number,
			]);
		}

		return $dataProvider;
	}
}
?>