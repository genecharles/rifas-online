<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\RaffleModel;
use App\Libraries\RafflePrize\PrizeDropdownService;
use App\Libraries\RafflePrize\StoreService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use App\Validation\RafflePrizeValidation;

class RafflesPrizesController extends BaseController
{
	private const VIEWS_DIRECTORY = 'RafflesPrizes/';

	public function manage(string $raffleCode)
	{

		$raffle = model(RaffleModel::class)->getByCode(code: $raffleCode, withPrizes: true);

		$data = [
			'title' => 'Gerenciar os prêmios da rifa',
			'raffle' => $raffle, 
			'prizesOptions' => (new PrizeDropdownService)->prizesOptions($raffle->prizes ?? []),
		];

		return view(self::VIEWS_DIRECTORY . 'manage', $data);
	}

	public function store(string $raffleCode):RedirectResponse
	{

		
		$rules = (new RafflePrizeValidation)->getRules();

		if (!$this->validate($rules)) {

			return redirect()->back()
			->withInput()
			->with('errors', $this->validator->getErrors());
		}

		$raffle = model(RaffleModel::class)->getByCode(code: $raffleCode);

		$storeService = new StoreService(raffle: $raffle, validatedData: $this->validator->getValidated());

		if(!$storeService->synchonize()){
			return redirect()->back()->with('danger', 'Ocorreu um erro. Tente novamente');
		}
		return redirect()->route('raffles.show', [$raffle->code])->with('success', 'Sucesso!');
	}

}
