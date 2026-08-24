<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Repositories\ReceitasRepository;

class SaidasController implements Controller
{

    public function __construct(private ReceitasRepository $receitasRepository)
    {
        
    }
    
    public function requestProcess()
    {
        $saidas = $this->receitasRepository->buscarSaidas();
        require_once __DIR__ . '/../../Views/saidas_receita.php';
    }
}