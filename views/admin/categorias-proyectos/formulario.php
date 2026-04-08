<?php
$esEdicion    = !empty($categoria);
$tituloPagina = $esEdicion ? 'Editar categoría' : 'Nueva categoría';
$breadcrumb   = [
  ['label' => 'Categorías proyectos', 'url' => BASE_URL . '/tom-workspace/categorias-proyectos'],
  ['label' => $tituloPagina, 'url' => ''],
];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title"><?= $esEdicion ? 'Editar categoría' : 'Nueva categoría' ?> <span class="page-title-sub">/ proyectos</span></h1>
</div>

<div class="card">
  <div class="card-body">
    <div class="form-section">
      <form method="post" action="<?= htmlspecialchars($accion, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
          <label class="form-label" for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="form-control" required
                 value="<?= htmlspecialchars($categoria['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Guardar
          </button>
          <a href="<?= BASE_URL ?>/tom-workspace/categorias-proyectos" class="btn btn-outline">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
