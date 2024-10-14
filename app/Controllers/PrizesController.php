<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Prize;
use App\Models\PrizeModel;
use App\Validation\PrizeValidation;
use CodeIgniter\HTTP\RedirectResponse;


class PrizesController extends BaseController
{
    private const VIEWS_DIRECTORY = 'Prizes/';

	private PrizeModel $prizeModel;

	public function __construct(){
		$this->prizeModel = model(PrizeModel::class);
	}

    public function index()
    {
        $data =[
        	'title' => 'Meus prêmios',
        	'prizes' => $this->prizeModel->all(),
        ];

        return view(self::VIEWS_DIRECTORY . 'index', $data);
    }

    public function new()
    {
        $data =[
        	'title' => 'Cria prêmio',
        	'prize' => new Prize(),
        	'route' => route_to('prizes.create'),
        	'hidden' => [],
        ];

        return view(self::VIEWS_DIRECTORY . 'form', $data);
    }



    public function create(): RedirectResponse
    {
        
        $rules = (new PrizeValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $prize = new Prize($this->validator->getValidated());

        if (!$id = $this->prizeModel->insert($prize)) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Ocorreu um erro. Tente novamente mais tarde');
        }

        $createdPrize = $this->prizeModel->find($id);


        return redirect()->route('prizes.show', [$createdPrize->code])->with('success', 'Sucesso!');     
    }



    public function show(string $code)
    {
        
        $data =[
            'title' => 'Detalhes do prêmio',
            'prize' => $this->prizeModel->getByCode(code: $code, withRaffles: true),
        ];

        return view(self::VIEWS_DIRECTORY . 'show', $data);
    }

    public function edit(string $code)
    {
        $prize = $this->prizeModel->getByCode(code: $code, withRaffles: true);
        //dd($code);
        $data =[
            'title' => 'Editar o prêmio',
            'prize' => $prize,
            'route' => route_to('prizes.update', $prize->code),
            'hidden' => ['_method' => 'PUT'],
        ];

        return view(self::VIEWS_DIRECTORY . 'form', $data);
    }


    public function update(string $code): RedirectResponse
    {
        
        $rules = (new PrizeValidation)->getRules();

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $prize = $this->prizeModel->getByCode(code: $code, withRaffles: false);

        $prize->fill($this->validator->getValidated());

        if (!$this->prizeModel->save($prize)) {
            return redirect()->back()
                ->withInput()
                ->with('danger', 'Ocorreu um erro. Tente novamente mais tarde');
        }

        return redirect()->route('prizes.show', [$prize->code])->with('success', 'Sucesso!');     
    }


    public function destroy(string $code): RedirectResponse
    {
        $this->prizeModel->whereCreator()->where(['code' => $code])->delete();

        return redirect()->route('prizes')->with('success', 'Sucesso!');  

    }
}
