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
        $porPagina = 15;
        $pagina = isset($_GET['pagina']) ? max(1, (int) $_GET['pagina']) : 1;

        
        $saidas = $this->receitasRepository->listarSaidasPaginado($pagina, $porPagina);
        $total = $this->receitasRepository->contarSaidas();
        $totalPaginas = (int) ceil($total / $porPagina);
        require_once __DIR__ . '/../../Views/saidas_receita.php';
    }
}