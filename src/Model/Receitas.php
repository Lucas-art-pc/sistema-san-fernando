<?php

namespace App\Model;

class Receitas
{
  private ?int $id_receita;
  private string $descricao_receita;
  private string $categoria_receita;
  private float $valor_receita;
  private string $tipo_receita;
  private string $data_receita;

  public function __construct($id_receita, $descricao_receita, $categoria_receita, $valor_receita, $data_receita,  $tipo_receita)
  {
    $this->id_receita = $id_receita;
    $this->descricao_receita = $descricao_receita;
    $this->categoria_receita = $categoria_receita;
    $this->valor_receita = $valor_receita;
    $this->data_receita = $data_receita;
    $this->tipo_receita = $tipo_receita;
  }

  public function getId()
  {
    return $this->id_receita;
  }

  public function getDescricao()
  {
    return $this->descricao_receita;
  }

  public function getCategoria()
  {
    return $this->categoria_receita;
  }

  public function getValor()
  {
    return $this->valor_receita;
  }


  public function getData()
  {
    return $this->data_receita;
  }

  public function getTipo() {
    return $this->tipo_receita;
  }
  
}
