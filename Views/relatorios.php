<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Relatórios | Barbearia Vinicius</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="./css/style-login.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
  if(window.jspdf){
    window.jsPDF = window.jspdf.jsPDF || window.jspdf.default || window.jsPDF || window.jspdf;
  }
</script>
</head>
<body>
  <div class="app">
        <?php require_once __DIR__ . '/Layouts/sidebar_dashboard.php' ?>
      <section class="page active" id="page-relatorios">
        <div class="page-head">
          <h2>Relatórios & Extratos</h2>
          <p>Gere relatórios financeiros detalhados e extratos por período</p>
        </div>

        <div class="filter-panel elegant">
          <div class="period-tabs" role="tablist">
            <button class="period-tab active" data-rperiod="dia">Diário</button>
            <button class="period-tab" data-rperiod="mes">Mensal</button>
            <button class="period-tab" data-rperiod="ano">Anual</button>
          </div>
          <div class="period-inputs">
            <div class="field" id="wrapDia">
              <label>Data</label>
              <input type="date" id="filtroDia" />
            </div>
            <div class="field hidden" id="wrapMes">
              <label>Mês</label>
              <input type="month" id="filtroMes" />
            </div>
            <div class="field hidden" id="wrapAno">
              <label>Ano</label>
              <input type="number" id="filtroAno" min="2000" max="2100" placeholder="2026" />
            </div>
            <div class="field">
              <label>Filtrar por tipo</label>
              <select id="filtroTipo">
                <option value="ambos">Entradas e Saídas</option>
                <option value="in">Apenas Entradas</option>
                <option value="out">Apenas Saídas</option>
              </select>
            </div>
          </div>
          <div class="form-actions">
            <button class="btn btn-primary" id="btnRelatorio">
              <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 17V7m0 10l-3-3m3 3l3-3M15 7v10m0-10l-3 3m3-3l3 3"/></svg>
              Gerar Relatório
            </button>
          </div>
        </div>

        <div id="reportOutput" class="report-output"></div>

        <div class="form-actions hidden" id="reportActions">
          <button class="btn btn-ghost" id="btnPrint">🖨️ Imprimir</button>
          <button class="btn btn-primary" id="btnPdf">📄 Exportar PDF</button>
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
</body>
</html>