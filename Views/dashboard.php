<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard | Fabrica San Fernando</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/style-login.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>
  <div class="app">
    <?php require_once __DIR__ . '/Layouts/sidebar_dashboard.php' ?>
    <section class="page active" id="page-dashboard">
      <div class="page-head">
        <h2>Visão Geral</h2>
        <p>Acompanhe o fluxo do salão e veja o desempenho da barbearia em tempo real</p>
      </div>

      <div class="period-panel">
        <div class="period-tabs" role="tablist">
          <button class="period-tab active" data-period="dia">Dia</button>
          <button class="period-tab" data-period="mes">Mês</button>
          <button class="period-tab" data-period="ano">Ano</button>
        </div>
        <div class="period-inputs">
          <div class="field" id="dashWrapDia">
            <label>Selecione a data</label>
            <input type="date" id="dashDia" />
          </div>
          <div class="field hidden" id="dashWrapMes">
            <label>Selecione o mês</label>
            <input type="month" id="dashMes" />
          </div>
          <div class="field hidden" id="dashWrapAno">
            <label>Selecione o ano</label>
            <input type="number" id="dashAno" min="2000" max="2100" placeholder="2026" />
          </div>
        </div>
      </div>

      <div class="cards cards-3">
        <div class="card">
          <div class="card-label" id="lblIn">Entradas</div>
          <div class="card-value in" id="periodIn">R$ <?= number_format($dadosDashboard['entradas'], 2, ',', '.') ?></div>
          <div class="card-sub" id="subIn"><?= $dadosDashboard['qtd_entradas'] ?> lançamentos</div>
        </div>
        <div class="card">
          <div class="card-label" id="lblOut">Saídas</div>
          <div class="card-value out" id="periodOut">R$ <?= number_format($dadosDashboard['saidas'], 2, ',', '.') ?></div>
          <div class="card-sub" id="subOut"><?= $dadosDashboard['qtd_saidas'] ?> lançamentos</div>
        </div>
        <div class="card highlight">
          <div class="card-label" id="lblProfit">Lucro</div>
          <div class="card-value" id="periodProfit">R$ <?= number_format($dadosDashboard['lucro'], 2, ',', '.') ?></div>
          <div class="card-sub" id="subProfit">Saldo do período</div>
        </div>
      </div>

      <div class="chart-panel">
        <div class="panel-head">
          <h3 id="chartTitle">Entradas vs Saídas</h3>
          <span class="panel-sub" id="chartSub">—</span>
        </div>
        <canvas id="mainChart" height="110"></canvas>
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

  <script type="module" src="./js/dashboard-valores.js"></script>
</body>

</html>