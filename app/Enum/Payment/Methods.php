<?php
declare(strict_types=1);

namespace App\Enum\Payment;

enum Methods: string {

	case Pix = 'pix';
	case Credit = 'credit_card';
	case Debit = 'debit_card';
	case Bitcoin = 'bitcoin';
	case Wallet = 'digital_wallet';

	//assim por diante ...

	public function label(): string
	{

		return match ($this){

			self::Pix => 'Pix',
			self::Credit => 'Cartão de Crédito',
			self::Debit => 'Cartão de Débito',
			self::Bitcoin => 'Bitcoin',
			self::Wallet => 'Carteira digital',
			default => 'Método desconhecido'
		};
	}

	public static function options(?string $paymentMethod = null): string{

		$options = [];
		$options[''] = '--- Escolha ---';

		foreach (self::cases() as $method) {
			$options[$method->value] = $method->label();
		}

		return form_dropdown(
			data: 'payment_method',
			options: $options,
			selected: old('payment_method', $paymentMethod),
			extra: ['class' => 'form-select', 'required' => true, 'id' => 'payment_method']
		);
	}
}

?>