<aside class="sidebar" id="sidebar">
  <div class="brand">
    <div class="brand-mark">FS</div>
    <div class="brand-text">
      <strong>Fabrica San Fernando</strong>
      <span>Gestão Financeira</span>
    </div>
  </div>
  <nav class="menu">
    <a href="/dashboard" class="menu-item active">
       <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12l9-9 9 9"/><path d="M5 10v10h14V10"/></svg>
        <path d="M3 2l9-9 9 9" />
        <path d="M5 14v10h14V10" />
      </svg>
      <span>Dashboard</span>
    </a>
    <a href="/entradas" class="menu-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 5v14" />
        <path d="M5 12l7 7 7-7" />
      </svg>
      <span>Entradas</span>
    </a>
    <a href="/saidas" class="menu-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 19V5" />
        <path d="M5 12l7-7 7 7" />
      </svg>
      <span>Saídas</span>
    </a>
    <a href="/relatorios" class="menu-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M4 4h16v16H4z" />
        <path d="M8 10h8M8 14h5" />
      </svg>
      <span>Relatórios</span>
    </a>
    <a href="/configuracoes" class="menu-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <circle cx="12" cy="12" r="3" />
        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" />
      </svg>
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
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M3 6h18M3 12h18M3 18h18" />
      </svg>
    </button>
    <div class="topbar-title">
      <h1 id="factoryName">Fábrica San Fernando</h1>
      <span class="subtitle">Painel de Controle Financeiro</span>
    </div>
    <div class="topbar-right">
      <button type="button" class="btn btn-ghost logout-btn" id="logoutBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
          <path d="M16 17l5-5-5-5" />
          <path d="M21 12H9" />
        </svg>
        <span>Sair</span>
      </button>
    </div>
  </header>