<?php
declare(strict_types=1);
namespace App\Libraries\RafflePrize;
use App\Models\RafflePrizeModel;
use App\Entities\Raffle;
class StoreService
{
	private RafflePrizeModel $model;
	private Raffle $raffle;
	private array $validatedData;
	public function __construct(Raffle $raffle, array $validatedData)
	{
		$this->model = model(RafflePrizeModel::class);
		$this->raffle = $raffle;
		$this->validatedData = $validatedData;
	}
//sincronizar na base de dados
	public function synchonize():bool{
		try {
			// abro a transction
			$this->model->db->transException(true)->transStart();
			//remover as anteriores
			$this->model->where(['raffle_id' => $this->raffle->id])->delete();
			//inserimos os prenios
			$this->model->insertBatch($this->prepareData());
			// fecho a transaction
			$this->model->db->transComplete();
			//retorna o resultado 
			return $this->model->db->transStatus();

		} catch (\Throwable $th) {
			log_message('error', '[ERROR] {exception}', ['exception' => $th]);
			return false;
		}
	}
	private function prepareData(): array{
		$dataProvider = [];
		foreach($this->validatedData['prizes'] as $prizeId){
			$dataProvider[] = [
				'raffle_id' => $this->raffle->id,
				'prize_id' => $prizeId,
			];
		}
		
		return $dataProvider;
	}
}
?>