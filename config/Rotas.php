<?php

use App\Controller\CadastraSaidaController;
use App\Controller\CadastraEntradasController;
use App\Controller\DashboardController;
use App\Controller\DashboardDadosController; // <-- novo
use App\Controller\EditaReceitasController;
use App\Controller\EntradasController;
use App\Controller\ExcluiReceitaController;
use App\Controller\GerarRelatorioController;
use App\Controller\HomeController;
use App\Controller\LoginController;
use App\Controller\RelatorioController;
use App\Controller\SaidasController;

return [
    'GET|/' => [HomeController::class, 'requestProcess'],
    'POST|/login' => [LoginController::class, 'requestProcess'],
    'GET|/dashboard' => [[DashboardController::class, 'requestProcess'], 'auth' => true],
    'GET|/dashboard/dados' => [[DashboardDadosController::class, 'requestProcess'], 'auth' => true], 
    'GET|/entradas' => [[EntradasController::class, 'requestProcess'], 'auth' => true],
    'GET|/saidas' => [[SaidasController::class, 'requestProcess'], 'auth' => true],
    'GET|/relatorios' => [[RelatorioController::class, 'requestProcess'], 'auth' => true],
    'POST|/cadastra-entrada' => [[CadastraEntradasController::class, 'requestProcess'], 'auth' => true],
    'POST|/cadastra-saida' => [[CadastraSaidaController::class, 'requestProcess'], 'auth' => true],
    'POST|/exclui-receita' => [[ExcluiReceitaController::class, 'requestProcess'], 'auth' => true],
    'POST|/edita-receita' => [[EditaReceitasController::class, 'requestProcess'], 'auth' => true],
    'GET|/relatorio/pdf' => [[GerarRelatorioController::class, 'requestProcess'], 'auth' => true]
];