<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Repositories\ReceitasRepository;

class DashboardController implements Controller
{

    public function __construct(private ReceitasRepository $receitasRepository)
    {
        
    }
    public function requestProcess()
    {
        $dadosDashboard = $this->receitasRepository->dadosDashboard(); 
        require_once __DIR__ . '/../../Views/dashboard.php';
    }
}