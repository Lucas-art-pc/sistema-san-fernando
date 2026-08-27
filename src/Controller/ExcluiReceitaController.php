<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Repositories\ReceitasRepository;

class ExcluiReceitaController implements Controller
{
    public function __construct(private ReceitasRepository $receitasRepository)
    {
    }

    public function requestProcess()
    {
        header('Content-Type: application/json');

        $idReceita = $_POST['idReceita'] ?? null;

        if (!$idReceita || !ctype_digit((string) $idReceita)) {
            http_response_code(400);
            echo json_encode(['sucesso' => false, 'erro' => 'ID inválido']);
            return;
        }

        try {
            $sucesso = $this->receitasRepository->deletaReceita((int) $idReceita);

            if (!$sucesso) {
                http_response_code(404);
                echo json_encode(['sucesso' => false, 'erro' => 'Registro não encontrado']);
                return;
            }

            echo json_encode(['sucesso' => true]);
        } catch (\Throwable $e) {
            http_response_code(500);
            echo json_encode(['sucesso' => false, 'erro' => 'Erro ao excluir registro']);
        }
    }
}