<?php
$rutaActual = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$rutaActual = str_replace(BASE, '', $rutaActual);
$estaEn = function(string $prefijo) use ($rutaActual): bool {
    return str_starts_with($rutaActual, $prefijo);
};
?>
<aside class="admin-sidebar">
  <div class="sidebar-brand">
    <span class="brand-label">Portfolio</span>
    <span class="brand-name">Panel Admin</span>
  </div>

  <nav class="sidebar-nav">
    <span class="nav-group-label">General</span>
    <a href="<?= BASE ?>/admin" class="sidebar-link <?= $rutaActual === '/admin' ? 'active' : '' ?>">
      <i class="bi bi-grid-1x2"></i> Dashboard
    </a>

    <span class="nav-group-label">Contenido</span>
    <a href="<?= BASE ?>/admin/proyectos" class="sidebar-link <?= $estaEn('/admin/proyectos') ? 'active' : '' ?>">
      <i class="bi bi-folder2-open"></i> Proyectos
    </a>
    <a href="<?= BASE ?>/admin/habilidades" class="sidebar-link <?= $estaEn('/admin/habilidades') ? 'active' : '' ?>">
      <i class="bi bi-lightning-charge"></i> Habilidades
    </a>
    <a href="<?= BASE ?>/admin/experiencia" class="sidebar-link <?= $estaEn('/admin/experiencia') ? 'active' : '' ?>">
      <i class="bi bi-briefcase"></i> Experiencia
    </a>

    <span class="nav-group-label">Catálogos</span>
    <a href="<?= BASE ?>/admin/categorias" class="sidebar-link <?= $estaEn('/admin/categorias') && !$estaEn('/admin/categorias-proyectos') ? 'active' : '' ?>">
      <i class="bi bi-tag"></i> Cat. Habilidades
    </a>
    <a href="<?= BASE ?>/admin/categorias-proyectos" class="sidebar-link <?= $estaEn('/admin/categorias-proyectos') ? 'active' : '' ?>">
      <i class="bi bi-tags"></i> Cat. Proyectos
    </a>

    <span class="nav-group-label">Sitio</span>
    <a href="<?= BASE ?>/" target="_blank" class="sidebar-link">
      <i class="bi bi-box-arrow-up-right"></i> Ver portfolio
    </a>
  </nav>

  <div class="sidebar-footer">
    <div class="sidebar-user">
      <div class="sidebar-avatar"><?= strtoupper(substr($_SESSION['nombre_usuario'] ?? 'A', 0, 1)) ?></div>
      <span class="sidebar-username"><?= htmlspecialchars($_SESSION['nombre_usuario'] ?? '', ENT_QUOTES, 'UTF-8') ?></span>
    </div>
    <form method="post" action="<?= BASE ?>/admin/logout">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">
      <button type="submit" class="btn-logout">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </button>
    </form>
  </div>
</aside>
