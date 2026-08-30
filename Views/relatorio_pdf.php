<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Helvetica, sans-serif; font-size: 12px; color: #222; }
    h1 { font-size: 18px; margin-bottom: 0; }
    .periodo { color: #666; margin-top: 4px; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ddd; padding: 6px 8px; text-align: left; }
    th { background: #f2f2f2; }
    .entrada { color: #1a7f37; }
    .saida { color: #c0392b; }
    .totais { margin-top: 20px; font-size: 13px; }
</style>
</head>
<body>
    <h1>Relatório Financeiro — Barbearia Vinicius</h1>
    <p class="periodo">Período: <?= htmlspecialchars($inicio) ?> até <?= htmlspecialchars($fim) ?></p>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($receitas as $r): ?>
            <tr>
                <td><?= htmlspecialchars($r->getDataReceita()) ?></td>
                <td><?= htmlspecialchars($r->getDescricaoReceita()) ?></td>
                <td><?= htmlspecialchars($r->getCategoriaReceita()) ?></td>
                <td class="<?= $r->getTipoReceita() === 'entrada' ? 'entrada' : 'saida' ?>">
                    <?= $r->getTipoReceita() === 'entrada' ? 'Entrada' : 'Saída' ?>
                </td>
                <td>R$ <?= number_format($r->getValorReceita(), 2, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totais">
        <p>Total de entradas: <strong>R$ <?= number_format($totalEntradas, 2, ',', '.') ?></strong></p>
        <p>Total de saídas: <strong>R$ <?= number_format($totalSaidas, 2, ',', '.') ?></strong></p>
        <p>Lucro: <strong>R$ <?= number_format($totalEntradas - $totalSaidas, 2, ',', '.') ?></strong></p>
    </div>
</body>
</html>