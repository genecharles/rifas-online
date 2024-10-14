<?php
declare(strict_types=1);

namespace App\Libraries\RafflePrize;
use App\Models\PrizeModel;

class PrizeDropdownService{
	public function prizesOptions(?array $previousPrizes = null): string{
		$prizes = model(PrizeModel::class)->all();

		if (empty($prizes)) {

			$anchor = '<br>Você ainda não tem prêmios criados<br>';
			$anchor .= anchor(
				uri: route_to('prizes.new'),
				title: 'Criar novo prêmio',
				attributes: ['class' => 'btn btn-outline-dark btn-sm']
			);

			return $anchor;
		}

		$options = [];
		$options[''] = '--- Selecione um ou mais prêmios ---';
		$selected = [];

		$previousPrizesIds = array_column($previousPrizes ?? [], 'id');

		foreach ($prizes as $prize) {

			if (in_array($prize->id, $previousPrizesIds)) {

				$selected[] = $prize->id;

			}

			$options[$prize->id] = $prize->title;
		}

		return form_multiselect(
			name: 'prizes[]',
			options: $options,
			selected: $selected,
			extra: ['class' => 'form-control', 'required' => true, 'id' => 'prizes']
		);
	}
}
?>