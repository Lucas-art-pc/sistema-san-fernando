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


    public function dadosDashboard(): array
    {
        return $this->getTotaisDia(date('Y-m-d'));
    }

    /**
     * Totais de entrada, saída e lucro de um dia específico.
     * Ex.: getTotaisDia('2026-08-26')
     */
    public function getTotaisDia(string $data): array
    {
        $sql = "SELECT
                    COALESCE(SUM(CASE WHEN tipo_receita = 'entrada' THEN valor_receita END), 0) AS entradas,
                    COALESCE(SUM(CASE WHEN tipo_receita = 'despesa' THEN valor_receita END), 0) AS saidas,
                    COUNT(CASE WHEN tipo_receita = 'entrada' THEN 1 END) AS qtd_entradas,
                    COUNT(CASE WHEN tipo_receita = 'despesa' THEN 1 END) AS qtd_saidas
                FROM tb_receitas
                WHERE data_receita = :data";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->execute();

        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        $entradas = (float) $resultado['entradas'];
        $saidas = (float) $resultado['saidas'];

        return [
            'entradas'     => $entradas,
            'saidas'       => $saidas,
            'lucro'        => $entradas - $saidas,
            'qtd_entradas' => (int) $resultado['qtd_entradas'],
            'qtd_saidas'   => (int) $resultado['qtd_saidas'],
            'grafico'      => [
                'labels'   => [$data],
                'entradas' => [$entradas],
                'saidas'   => [$saidas],
            ],
        ];
    }

    /**
     * Totais do mês + série diária (para o gráfico) de um mês/ano.
     * Ex.: getTotaisMes(2026, 8)
     */
    public function getTotaisMes(int $ano, int $mes): array
    {
        $sql = "SELECT
                    EXTRACT(DAY FROM data_receita)::int AS chave,
                    COALESCE(SUM(CASE WHEN tipo_receita = 'entrada' THEN valor_receita END), 0) AS entradas,
                    COALESCE(SUM(CASE WHEN tipo_receita = 'despesa' THEN valor_receita END), 0) AS saidas,
                    COUNT(CASE WHEN tipo_receita = 'entrada' THEN 1 END) AS qtd_entradas,
                    COUNT(CASE WHEN tipo_receita = 'despesa' THEN 1 END) AS qtd_saidas
                FROM tb_receitas
                WHERE EXTRACT(YEAR FROM data_receita) = :ano
                  AND EXTRACT(MONTH FROM data_receita) = :mes
                GROUP BY chave
                ORDER BY chave";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->execute();

        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Preenche todos os dias do mês, mesmo os sem lançamento,
        // pra o gráfico não pular dias.
        $diasNoMes = (int) date('t', mktime(0, 0, 0, $mes, 1, $ano));
        $porChave = array_fill(1, $diasNoMes, ['entradas' => 0.0, 'saidas' => 0.0, 'qtd_entradas' => 0, 'qtd_saidas' => 0]);

        $this->mesclarLinhas($porChave, $linhas);

        return $this->montarResposta($porChave, fn($dia) => str_pad((string) $dia, 2, '0', STR_PAD_LEFT));
    }

    /**
     * Totais do ano + série mensal (para o gráfico) de um ano.
     * Ex.: getTotaisAno(2026)
     */
    public function getTotaisAno(int $ano): array
    {
        $sql = "SELECT
                    EXTRACT(MONTH FROM data_receita)::int AS chave,
                    COALESCE(SUM(CASE WHEN tipo_receita = 'entrada' THEN valor_receita END), 0) AS entradas,
                    COALESCE(SUM(CASE WHEN tipo_receita = 'despesa' THEN valor_receita END), 0) AS saidas,
                    COUNT(CASE WHEN tipo_receita = 'entrada' THEN 1 END) AS qtd_entradas,
                    COUNT(CASE WHEN tipo_receita = 'despesa' THEN 1 END) AS qtd_saidas
                FROM tb_receitas
                WHERE EXTRACT(YEAR FROM data_receita) = :ano
                GROUP BY chave
                ORDER BY chave";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();

        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $porChave = array_fill(1, 12, ['entradas' => 0.0, 'saidas' => 0.0, 'qtd_entradas' => 0, 'qtd_saidas' => 0]);
        $this->mesclarLinhas($porChave, $linhas);

        $nomesMeses = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

        return $this->montarResposta($porChave, fn($mes) => $nomesMeses[$mes - 1]);
    }

    /**
     * Injeta os resultados da query (por dia ou por mês) dentro do array
     * pré-preenchido com zeros.
     */
    private function mesclarLinhas(array &$porChave, array $linhas): void
    {
        foreach ($linhas as $linha) {
            $porChave[(int) $linha['chave']] = [
                'entradas'     => (float) $linha['entradas'],
                'saidas'       => (float) $linha['saidas'],
                'qtd_entradas' => (int) $linha['qtd_entradas'],
                'qtd_saidas'   => (int) $linha['qtd_saidas'],
            ];
        }
    }

    /**
     * Monta a resposta padrão (totais + série do gráfico) a partir de
     * um array indexado por dia ou mês.
     */
    private function montarResposta(array $porPeriodo, callable $formatarLabel): array
    {
        $labels = [];
        $entradasSerie = [];
        $saidasSerie = [];
        $totalEntradas = 0.0;
        $totalSaidas = 0.0;
        $totalQtdEntradas = 0;
        $totalQtdSaidas = 0;

        foreach ($porPeriodo as $chave => $valores) {
            $labels[] = $formatarLabel($chave);
            $entradasSerie[] = $valores['entradas'];
            $saidasSerie[] = $valores['saidas'];
            $totalEntradas += $valores['entradas'];
            $totalSaidas += $valores['saidas'];
            $totalQtdEntradas += $valores['qtd_entradas'];
            $totalQtdSaidas += $valores['qtd_saidas'];
        }

        return [
            'entradas'     => $totalEntradas,
            'saidas'       => $totalSaidas,
            'lucro'        => $totalEntradas - $totalSaidas,
            'qtd_entradas' => $totalQtdEntradas,
            'qtd_saidas'   => $totalQtdSaidas,
            'grafico'      => [
                'labels'   => $labels,
                'entradas' => $entradasSerie,
                'saidas'   => $saidasSerie,
            ],
        ];
    }


    public function listarEntradasPaginado(int $pagina, int $porPagina = 15): array
    {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT * FROM tb_receitas 
            WHERE tipo_receita = :tipo
            ORDER BY data_receita DESC 
            LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':tipo', 'entrada', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($linha) => new Receitas(
            $linha['id_receita'],
            $linha['descricao_receita'],
            $linha['categoria_receita'],
            $linha['valor_receita'],
            $linha['data_receita'],
            $linha['tipo_receita'],
        ), $linhas);
    }

    public function contarEntradas(): int
    {
        $sql = "SELECT COUNT(*) FROM tb_receitas WHERE tipo_receita = 'entrada'";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }
    public function listarSaidasPaginado(int $pagina, int $porPagina = 15): array
    {
        $offset = ($pagina - 1) * $porPagina;

        $sql = "SELECT * FROM tb_receitas 
            WHERE tipo_receita = :tipo
            ORDER BY data_receita DESC 
            LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':tipo', 'despesa', PDO::PARAM_STR);
        $stmt->bindValue(':limit', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(fn($linha) => new Receitas(
            $linha['id_receita'],
            $linha['descricao_receita'],
            $linha['categoria_receita'],
            $linha['valor_receita'],
            $linha['data_receita'],
            $linha['tipo_receita'],
        ), $linhas);
    }

    public function contarSaidas(): int
    {
        $sql = "SELECT COUNT(*) FROM tb_receitas WHERE tipo_receita = 'despesa'";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }

    public function exibirRelatorio($data_inicio, $data_fim, $tipo_receita)
{
    $sqlEntradaESaida = "SELECT * FROM tb_receitas
            WHERE data_receita >= :data_inicio
            AND data_receita <= :data_fim";

    $sqlEntradaOuSaida = "SELECT * FROM tb_receitas
            WHERE data_receita >= :data_inicio
            AND data_receita <= :data_fim
            AND tipo_receita = :tipo_receita";

    if (!isset($tipo_receita)) {
        $stmt = $this->pdo->prepare($sqlEntradaESaida);
        $stmt->bindValue(':data_inicio', $data_inicio);
        $stmt->bindValue(':data_fim', $data_fim);
    } else {
        $stmt = $this->pdo->prepare($sqlEntradaOuSaida);
        $stmt->bindValue(':data_inicio', $data_inicio);
        $stmt->bindValue(':data_fim', $data_fim);
        $stmt->bindValue(':tipo_receita', $tipo_receita);
    }

    $stmt->execute();
    $linhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map(fn($linha) => new Receitas(
        $linha['id_receita'],
        $linha['descricao_receita'],
        $linha['categoria_receita'],
        $linha['valor_receita'],
        $linha['data_receita'],
        $linha['tipo_receita'],
    ), $linhas);
}


  public function deletaReceita($id): bool
{
    $sql = "DELETE FROM tb_receitas WHERE id_receita = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}
}
