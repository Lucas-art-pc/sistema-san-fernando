<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Configurações | Barbearia Vinicius</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css" />
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
    <?=
    require_once __DIR__ . '/Layouts/sidebar_dashboard.php'
    ?>

    <aside class="sidebar" id="sidebar">
      <div class="brand">
        <div class="brand-mark">FS</div>
        <div class="brand-text">
          <strong>Fabrica San Fernando</strong>
          <span>Gestão Financeira</span>
        </div>
      </div>
      <nav class="menu">
        <a href="dashboard.html" class="menu-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l9-9 9 9"/><path d="M5 10v10h14V10"/></svg>
          <span>Dashboard</span>
        </a>
        <a href="entradas.html" class="menu-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14"/><path d="M5 12l7 7 7-7"/></svg>
          <span>Entradas</span>
        </a>
        <a href="saidas.html" class="menu-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 19V5"/><path d="M5 12l7-7 7 7"/></svg>
          <span>Saídas</span>
        </a>
        <a href="relatorios.html" class="menu-item">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16v16H4z"/><path d="M8 10h8M8 14h5"/></svg>
          <span>Relatórios</span>
        </a>
        <a href="config.html" class="menu-item active">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
          <span>Configurações</span>
        </a>
      </nav>
      <div class="sidebar-foot">
        <span>© 2026 Barbearia Vinicius</span>
      </div>
    </aside>
    <main class="main">
      <header class="topbar">
        <button class="menu-toggle" id="menuToggle" aria-label="Abrir menu">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
        </button>
        <div class="topbar-title">
          <h1 id="factoryName">Configurações</h1>
          <span class="subtitle">Preferências do sistema</span>
        </div>
        <div class="topbar-right">
          <button type="button" class="btn btn-ghost logout-btn" id="logoutBtn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>
            <span>Sair</span>
          </button>
          <div class="datetime">
            <strong id="clock">--:--:--</strong>
            <span id="today">--</span>
          </div>
        </div>
      </header>
      <section class="page active" id="page-config">
        <div class="page-head">
          <h2>Configurações</h2>
          <p>Personalize seu sistema</p>
        </div>
        <form class="form" id="formConfig">
          <div class="field grow">
            <label>Nome da Barbearia</label>
            <input type="text" name="nome" placeholder="Nome exibido no cabeçalho" />
          </div>
          <div class="form-actions">
            <button type="submit" class="btn btn-primary">Salvar</button>
          </div>
        </form>
        <div class="table-panel">
          <div class="panel-head"><h3>Dados do Sistema</h3></div>
          <div style="padding:1.2rem 1.4rem">
            <p style="margin:.4rem 0;color:#555">Todos os dados são armazenados localmente no seu navegador (LocalStorage).</p>
            <button class="btn btn-danger" id="btnReset" style="margin-top:.8rem">Apagar Todos os Dados</button>
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

  <script>
    (function () {
      const authSession = sessionStorage.getItem('authSession');
      if (!authSession) {
        window.location.replace('./login/index.html');
      }
    })();
  </script>
  <script src="java.js"></script>
</body>
</html>