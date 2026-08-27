<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Repositories\ReceitasRepository;

/**
 * Endpoint AJAX consumido pelo dashboard.js quando o usuário troca
 * entre as abas Dia / Mês / Ano.
 *
 * GET ?periodo=dia&data=2026-08-26
 * GET ?periodo=mes&ano=2026&mes=8
 * GET ?periodo=ano&ano=2026
 *
 * Aponte uma rota (ex.: /dashboard/dados) pra esse controller no seu
 * roteador, do mesmo jeito que já faz com o DashboardController.
 */
class DashboardDadosController implements Controller
{
    public function __construct(private ReceitasRepository $receitasRepository)
    {
    }

    public function requestProcess()
    {
        header('Content-Type: application/json; charset=utf-8');

        $periodo = $_GET['periodo'] ?? 'dia';

        try {
            switch ($periodo) {
                case 'dia':
                    $data = $_GET['data'] ?? date('Y-m-d');
                    $resultado = $this->receitasRepository->getTotaisDia($data);
                    break;

                case 'mes':
                    $ano = (int) ($_GET['ano'] ?? date('Y'));
                    $mes = (int) ($_GET['mes'] ?? date('n'));
                    $resultado = $this->receitasRepository->getTotaisMes($ano, $mes);
                    break;

                case 'ano':
                    $ano = (int) ($_GET['ano'] ?? date('Y'));
                    $resultado = $this->receitasRepository->getTotaisAno($ano);
                    break;

                default:
                    http_response_code(400);
                    echo json_encode(['erro' => 'Período inválido. Use dia, mes ou ano.']);
                    return;
            }

            echo json_encode($resultado);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro ao buscar dados do dashboard', 'detalhe' => $e->getMessage()]);
        }
    }
}