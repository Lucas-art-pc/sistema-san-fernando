<?php

namespace App\Controller;

use App\Controller\Controller;
use App\Model\Receitas;
use App\Repositories\ReceitasRepository;

class EditaReceitasController implements Controller
{

  public function __construct(private ReceitasRepository $receitasRepository) {}
  public function requestProcess()
  {
    header('Content-Type: application/json');

    if(!isset($_POST['atualiza'])){
      echo json_encode(['sucesso' => false, 'erro' => 'Erro no botao']);
      return;
    }

    try {
      $entrada = new Receitas(
        $_POST['id_receita'] ?? null,
        $_POST['descricao_receita'] ?? null,
        $_POST['categoria_receita'] ?? null,
        $_POST['valor_receita'] ?? null,
        $_POST['data_receita'] ?? null,
        $_POST['tipo_receita'] ?? null
      );

      $this->receitasRepository->atualizaReceita($entrada);

      echo json_encode(['sucesso' => true]);
    } catch (\Throwable $e) {
    echo json_encode(['sucesso' => false, 'erro' => $e->getMessage()]);
}
    
  }
}
