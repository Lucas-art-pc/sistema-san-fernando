<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Saídas | Fabrica San Fernando</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./css/style-login.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>
  <div class="app">
    <?php require_once __DIR__ . '/Layouts/sidebar_dashboard.php' ?>
    <section class="page active" id="page-saidas">
      <div class="page-head">
        <h2>Saídas</h2>
        <p>Registre e gerencie as despesas</p>
      </div>
      <form class="form" id="formSaida" action="/cadastra-saida" method="post">
        <input type="hidden" name="id" />
        <div class="field grow">
          <label>Descrição</label>
          <input type="text" name="descricao_receita" required placeholder="Ex: Compra de produtos" />
        </div>
        <div class="field">
          <label>Categoria</label>
          <select name="categoria_receita" required>
            <option value="">Selecione</option>
            <option value="produtos">Produtos</option>
            <option value="salarios">Salários</option>
            <option value="aluguel">Aluguel</option>
            <option value="energia">Energia</option>
            <option value="impostos">Impostos</option>
            <option value="outros">Outros</option>
          </select>
        </div>
        <div class="field">
          <label>Valor (R$)</label>
          <input type="number" step="0.010" name="valor_receita" required placeholder="0.00" />
        </div>
        <div class="field">
          <label>Data</label>
          <input type="date" name="data_receita" required />
        </div>


        <div class="form-actions">
          <button type="submit" name="cadastra" class="btn btn-primary">Salvar Saída</button>
          <button type="reset" class="btn btn-ghost">Limpar</button>
        </div>
      </form>

      <div class="table-panel">
        <div class="panel-head">
          <h3>Saídas Registradas</h3>
        </div>
        <div class="table-controls" style="padding:.6rem 1.2rem;display:flex;gap:1rem;align-items:center">
          <label style="font-size:13px">Agrupar por:&nbsp;
            <select id="groupModeSaidas" style="padding:.3rem .5rem;border-radius:8px;border:1px solid #e6e9ef">
              <option value="none">Nenhum</option>
              <option value="date">Dia</option>
              <option value="month">Mês</option>
              <option value="year">Ano</option>
            </select>
          </label>
        </div>
        <div class="table-wrap">
          <table class="table" id="tabela">
            <thead>
              <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th class="col-valor">Valor</th>
                <th>Tipo</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($saidas as $saida): ?>
                <tr data-id="<?= $saida->getId() ?>">
                  <td><?= date('d/m/Y', strtotime($saida->getData())) ?></td>
                  <td><?= htmlspecialchars($saida->getDescricao()) ?></td>
                  <td><?= htmlspecialchars($saida->getCategoria()) ?></td>
                  <td>R$ <?= number_format($saida->getValor(), 2, ',', '.') ?></td>
                  <td><?= $saida->getTipo() ?></td>
                  <td class="col-acoes">
                    <button type="button" class="btn-icon btn-editar" data-id="<?= $saida->getId() ?>" title="Editar">
                      ✏️
                    </button>
                    <button type="button" class="btn-icon btn-excluir" data-id="<?= $saida->getId() ?>" title="Excluir">
                      🗑️
                    </button>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="table-footer">
          <div id="paginationSaidas" class="pagination">
            <a href="?pagina=1" class="btn-pagina <?= $pagina <= 1 ? 'disabled' : '' ?>">«</a>
            <a href="?pagina=<?= max(1, $pagina - 1) ?>" class="btn-pagina <?= $pagina <= 1 ? 'disabled' : '' ?>">‹</a>

            <?php
            $inicio = max(1, $pagina - 2);
            $fim = min($totalPaginas, $pagina + 2);

            if ($inicio > 1) echo '<span class="btn-pagina disabled">...</span>';

            for ($i = $inicio; $i <= $fim; $i++):
            ?>
              <a href="?pagina=<?= $i ?>" class="btn-pagina <?= $i === $pagina ? 'active' : '' ?>"><?= $i ?></a>
            <?php endfor; ?>

            <?php if ($fim < $totalPaginas) echo '<span class="btn-pagina disabled">...</span>'; ?>

            <a href="?pagina=<?= min($totalPaginas, $pagina + 1) ?>" class="btn-pagina <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">›</a>
            <a href="?pagina=<?= $totalPaginas ?>" class="btn-pagina <?= $pagina >= $totalPaginas ? 'disabled' : '' ?>">»</a>
          </div>
        </div>
      </div>
    </section>
    </main>
  </div>

  <div class="toast-wrap" id="toastWrap"></div>

  <div class="modal" id="modalConfirm">
    <div class="modal-card">
      <h3 id="modalTitle">Confirmar</h3>
      <p id="modalMsg">Tem certeza?</p>
      <div class="modal-actions">
        <button class="btn btn-ghost" id="modalCancel">Cancelar</button>
        <button class="btn btn-danger" id="modalOk">Confirmar</button>
      </div>
    </div>
  </div>

  <script src="./js/listagem-receitas.js"></script>
</body>


</html>