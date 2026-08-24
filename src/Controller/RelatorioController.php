<?php

namespace App\Controller;

use App\Controller\Controller;

class RelatorioController implements Controller
{
    public function requestProcess()
    {
        require_once __DIR__ . '/../../Views/relatorios.php';
    }
}