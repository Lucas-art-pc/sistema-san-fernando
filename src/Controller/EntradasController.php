<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Repositories\ReceitasRepository;

class EntradasController implements Controller
{
    public function __construct(private ReceitasRepository $receitasRepository)
    {

    }
    public function requestProcess()
    {
        $entradas = $this->receitasRepository->buscarEntradas();
        require_once __DIR__ . '/../../Views/entradas_receita.php';
    }
}