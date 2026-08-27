<aside class="sidebar" id="sidebar">
  <div class="brand">
    <div class="brand-mark">FS</div>
    <div class="brand-text">
      <strong>Fabrica San Fernando</strong>
      <span>Gestão Financeira</span>
    </div>
  </div>
  <?php
  $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  function isActive($path, $currentPath) {
      return $path === $currentPath ? 'active' : '';
  }
?>
<nav class="menu">
    <a href="/dashboard" class="menu-item <?= isActive('/dashboard', $currentPath) ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M3 12l9-9 9 9"/>
        <path d="M5 10v10h14V10"/>
      </svg>
      <span>Dashboard</span>
    </a>
    <a href="/entradas" class="menu-item <?= isActive('/entradas', $currentPath) ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 5v14" />
        <path d="M5 12l7 7 7-7" />
      </svg>
      <span>Entradas</span>
    </a>
    <a href="/saidas" class="menu-item <?= isActive('/saidas', $currentPath) ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 19V5" />
        <path d="M5 12l7-7 7 7" />
      </svg>
      <span>Saídas</span>
    </a>
    <a href="/relatorios" class="menu-item <?= isActive('/relatorios', $currentPath) ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M4 4h16v16H4z" />
        <path d="M8 10h8M8 14h5" />
      </svg>
      <span>Relatórios</span>
    </a>
</nav>
  <div class="sidebar-foot">
    <span>© <?= date('Y'); ?> Fabrica San Fernando</span>
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