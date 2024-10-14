<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Raffle;
use App\Models\RaffleModel;
use App\Validation\RaffleValidation;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

class RafflesController extends BaseController
{
	private const VIEWS_DIRECTORY = 'Raffles/';

	private RaffleModel $raffleModel;

	public function __construct(){
		$this->raffleModel = model(RaffleModel::class);
	}

    public function index()
    {
        $data =[
        	'title' => 'Minhas rifas',
        	'raffles' => $this->raffleModel->all(),
        ];

        return view(self::VIEWS_DIRECTORY . 'index', $data);
    }


    public function new()
    {
        $data = [
        	'title'  => 'Criar rifa',
        	'raffle' => new Raffle(),
        ];

        return view(self::VIEWS_DIRECTORY . 'new', $data);
    }

    public function create(): RedirectResponse
    {
        
        $rules = (new RaffleValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $raffle = new Raffle($this->validator->getValidated());

        if (!$id = $this->raffleModel->insert($raffle)) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Ocorreu um erro. Tente novamente mais tarde');
        }

        $createdRaffle = $this->raffleModel->find($id);


        return redirect()->route('raffles.show', [$createdRaffle->code])->with('success', 'Sucesso!');     
    }


    public function show(string $code)
    {        

        $data = [
            'title'  => 'Detalhes da minha rifa',
            'raffle' => $this->raffleModel->getByCode(code: $code, withPrizes: true),
        ];

        return view(self::VIEWS_DIRECTORY . 'show', $data);
    }


    public function destroy(string $code): RedirectResponse
    {
        $this->raffleModel->whereCreator()->where(['code' => $code])->delete();

        return redirect()->route('raffles')->with('success', 'Sucesso!');  

    }



}
