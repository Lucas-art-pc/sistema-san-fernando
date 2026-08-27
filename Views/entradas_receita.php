<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Entradas | Fabrica San Fernando</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/style-login.css" />
</head>

<body>
  <div class="app">
    <?php require_once __DIR__ . '/Layouts/sidebar_dashboard.php' ?>

    <section class="page active" id="page-entradas">
      <div class="page-head">
        <h2>Entradas</h2>
        <p>Registre e gerencie as entradas financeiras</p>
      </div>

      <form class="form" id="formEntrada" action="/cadastra-entrada" method="POST">
        <div class="field grow">
          <label>Descrição</label>
          <input type="text" name="descricao_receita" required placeholder="Ex: Corte + barba" />
        </div>
        <div class="field">
          <label>Valor (R$)</label>
          <input type="number" step="0.010" name="valor_receita" required placeholder="0.00" />
        </div>
        <input type="hidden" name="id" />
        <div class="field">
          <label>Data</label>
          <input type="date" name="data_receita" required />
        </div>
        <div class="field">
          <label>Categoria</label>
          <select name="categoria_receita" required>
            <option value="">Selecione</option>
            <option value="servicos">Serviços</option>
            <option value="produtos">Produtos</option>
            <option value="assinaturas">Assinaturas</option>
            <option value="outros">Outros</option>
          </select>
        </div>
        <div class="form-actions">
          <button type="submit" name="cadastra" class="btn btn-primary">Salvar Entrada</button>
          <button type="reset" class="btn btn-ghost">Limpar</button>
        </div>
      </form>

      <div class="table-panel">
        <div class="panel-head">
          <h3>Entradas Registradas</h3>
        </div>
        <div class="table-controls" style="padding:.6rem 1.2rem;display:flex;gap:1rem;align-items:center">
          <label style="font-size:13px">Agrupar por:&nbsp;
            <select id="groupModeEntradas" style="padding:.3rem .5rem;border-radius:8px;border:1px solid #e6e9ef">
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
              <?php foreach ($entradas as $entrada): ?>
                <tr>
                  <td><?= date('d/m/Y', strtotime($entrada->getData())) ?></td>
                  <td><?= htmlspecialchars($entrada->getDescricao()) ?></td>
                  <td><?= htmlspecialchars($entrada->getCategoria()) ?></td>
                  <td>R$ <?= number_format($entrada->getValor(), 2, ',', '.') ?></td>
                  <td><?= $entrada->getTipo() ? 'Entrada' : 'Despesa' ?></td>
                  <td class="col-acoes">
                    <button type="button" class="btn-icon btn-editar" data-id="<?= $entrada->getId() ?>" title="Editar">
                      ✏️
                    </button>
                    <button type="button" class="btn-icon btn-excluir" data-id="<?= $entrada->getId() ?>" title="Excluir">
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