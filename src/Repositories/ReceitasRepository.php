<?php

namespace App\Repositories;

use App\Model\Receitas;
use PDO;

class ReceitasRepository
{
    public function __construct(private \PDO $pdo) {}

    public function adicionarReceita(Receitas $receitas)
    {
        $sql = "INSERT INTO tb_receitas (descricao_receita, categoria_receita, valor_receita, data_receita, tipo_receita) 
            VALUES (:descricao_receita, :categoria_receita, :valor_receita, :data_receita, :tipo_receita)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':descricao_receita', $receitas->getDescricao());
        $stmt->bindValue(':categoria_receita', $receitas->getCategoria());
        $stmt->bindValue(':valor_receita', $receitas->getValor());
        $stmt->bindValue(':data_receita', $receitas->getData());
        $stmt->bindValue(':tipo_receita', $receitas->getTipo());
        $stmt->execute();
    }

    public function buscarTodas()
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM tb_receitas ORDER BY data_receita DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarEntradas()
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM tb_receitas WHERE tipo_receita = 'entrada'"
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($row) {
            return new Receitas(
                $row['id_receita'],
                $row['descricao_receita'],
                $row['categoria_receita'],
                $row['valor_receita'],
                $row['data_receita'],
                $row['tipo_receita']
            );
        }, $rows);
    }
    public function buscarSaidas()
    {
        $stmt = $this->pdo->query(
            "SELECT * FROM tb_receitas WHERE tipo_receita = 'despesa'"
        );
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function ($row) {
            return new Receitas(
                $row['id_receita'],
                $row['descricao_receita'],
                $row['categoria_receita'],
                $row['valor_receita'],
                $row['data_receita'],
                $row['tipo_receita']
            );
        }, $rows);
    }
}
