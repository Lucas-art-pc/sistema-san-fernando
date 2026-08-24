<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\Receitas;
use App\Repositories\ReceitasRepository;

class CadastraSaidaController implements Controller
{

public function __construct(private ReceitasRepository $receitasRepository){

    }
    public function requestProcess()
    {
        if(isset($_POST['cadastra'])){

            $tipoReceita = 'despesa';
            $saida = new Receitas(
              $_POST['id_receita'] ?? null,
              $_POST['descricao_receita'],
              $_POST['categoria_receita'],
              $_POST['valor_receita'],
              $_POST['data_receita'],
              $tipoReceita
            );

           

            $this->receitasRepository->adicionarReceita($saida);

            header('Location: /saidas');
        }

        header('Location: /saidas');
    }
}