<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Raffle\ListService;
use App\Enum\Payment\Methods;
use App\Entities\Raffle;
use App\Libraries\Raffle\AvailableNumbersService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\RedirectResponse;
use App\Libraries\Ticket\StoreService;
use CodeIgniter\I18n\Time;


class RafflesTicketsController extends BaseController
{
	public const CHOSEN_SESSION_NUMBERS = 'chosen_session_numbers';

	private const VIEWS_DIRECTORY = 'RafflesTickets/';


    public function display(string $raffleCode)
    {
    	//limpamos os numeros escolhidos anteriormente que pode estar na sessao
        session()->remove(self::CHOSEN_SESSION_NUMBERS);

        $raffle = (new ListService)->single(code: $raffleCode);

        $raffle->tickets_availables = (new AvailableNumbersService)->get(raffle: $raffle);

        $data = [
        	'title' => 'Escolha seus números',
        	'raffle' => $raffle,
        ];

        return view(self::VIEWS_DIRECTORY . 'display', $data);
    }



    public function reserveNumbers(): Response{

    	$request = $this->request->getJSON(assoc: true);

    	session()->set(self::CHOSEN_SESSION_NUMBERS, $request['selected_numbers']);

    	return $this->response->setJSON(['success' => true]);

    }



    public function confirm(string $raffleCode){

    	$raffle = (new ListService)->single(code: $raffleCode);

    	if (!$raffle->hasTicketsRemaining()) {

    		return redirect()->route('home')->with('info', 'Não há mais bilhetes disponíveis para compra');
    	}

    	$chosenSessionNumbers = session(self::CHOSEN_SESSION_NUMBERS);

    	if (empty($chosenSessionNumbers)) {

    		return redirect()->route('home')->with('info', 'Não foi possível identificar os números que você escolheu');
    	}

    	//ordeno os numeros escolhidos
    	sort($chosenSessionNumbers);

    	//somamos quanto o user devera pagar
    	$amountToPay = number_to_currency(
    		num: (count($chosenSessionNumbers) * $raffle->price) / 100,
    		currency: 'BRL',
    		fraction: 2
    	);

    	$data = [
    		'title' 				=> 'Confirme os números e realize o pagamento',
    		'raffle' 				=> $raffle,
    		'numbers'				=> implode(', ', $chosenSessionNumbers), // exibir os Nrs 
    		'paymentMethodsOptions' => Methods::options(),
    		'amountToPay' 			=> $amountToPay, // exibiremos no botao de submite
    	];

    	return view(self::VIEWS_DIRECTORY . 'confirm', $data);

    }



    public function pay(string $raffleCode) : RedirectResponse{

    	$raffle = (new ListService)->single(code: $raffleCode);

    	if (!$raffle->hasTicketsRemaining()) {

    		return redirect()->route('home')->with('info', 'Não há mais bilhetes disponíveis para compra');
    	}

    	$paymentMethod = (string) $this->request->getPost('payment_method');


    	$storeService = new StoreService(
    		raffle: $raffle, 
    		paymentMethod: $paymentMethod, 
    		chosenNumbers: session(self::CHOSEN_SESSION_NUMBERS)
    	);

    	if (!$storeService->execute()) {
    		
    		return redirect()->back()->with('danger', 'Não foi possível processar o pagamento.');
    	}

    	$timeMoreTwoHours = Time::now()->addHours(2);

    	session()->remove(self::CHOSEN_SESSION_NUMBERS);

    	$messageAfterPay = "Sucesso! Seus números ficarão reservados até {$timeMoreTwoHours}.
    	 Depois desse prazo, caso o pagamento não tenha sido confirmado, eles serão disponibilizados para compra.";

    	 return redirect()->route('home')->with('success', $messageAfterPay);

    }

}
