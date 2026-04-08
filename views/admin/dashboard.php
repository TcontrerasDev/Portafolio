<?php
$tituloPagina = 'Dashboard';
$breadcrumb   = [];
require __DIR__ . '/layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title">Dashboard</h1>
</div>

<div class="stat-grid">
  <div class="stat-card">
    <div class="stat-icon blue"><i class="bi bi-folder2-open"></i></div>
    <div class="stat-value"><?= $totalProyectos ?></div>
    <div class="stat-label">Proyectos</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon amber"><i class="bi bi-lightning-charge"></i></div>
    <div class="stat-value"><?= $totalHabilidades ?></div>
    <div class="stat-label">Habilidades</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="bi bi-briefcase"></i></div>
    <div class="stat-value"><?= $totalExperiencia ?></div>
    <div class="stat-label">Experiencias</div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red"><i class="bi bi-tag"></i></div>
    <div class="stat-value"><?= $totalCategorias ?></div>
    <div class="stat-label">Categorías</div>
  </div>
</div>

<div class="card">
  <div class="card-body-actions">
    <a href="<?= BASE ?>/admin/proyectos/crear" class="btn btn-outline">
      <i class="bi bi-plus-lg"></i> Nuevo proyecto
    </a>
    <a href="<?= BASE ?>/admin/habilidades/crear" class="btn btn-outline">
      <i class="bi bi-plus-lg"></i> Nueva habilidad
    </a>
    <a href="<?= BASE ?>/admin/experiencia/crear" class="btn btn-outline">
      <i class="bi bi-plus-lg"></i> Nueva experiencia
    </a>
  </div>
</div>

<?php require __DIR__ . '/layout/footer.php'; ?>
