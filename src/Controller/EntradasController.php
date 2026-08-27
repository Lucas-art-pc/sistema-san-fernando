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
        $porPagina = 15;
        $pagina = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;

        
        
        $entradas = $this->receitasRepository->listarEntradasPaginado($pagina, $porPagina);
        $total = $this->receitasRepository->contarSaidas();
        $totalPaginas = (int) ceil($total / $porPagina);
        require_once __DIR__ . '/../../Views/entradas_receita.php';
    }
}