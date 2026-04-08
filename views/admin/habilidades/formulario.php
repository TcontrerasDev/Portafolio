<?php
$esEdicion    = !empty($habilidad);
$tituloPagina = $esEdicion ? 'Editar habilidad' : 'Nueva habilidad';
$breadcrumb   = [
  ['label' => 'Habilidades', 'url' => BASE_URL . '/admin/habilidades'],
  ['label' => $tituloPagina, 'url' => ''],
];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title"><?= $esEdicion ? 'Editar habilidad' : 'Nueva habilidad' ?></h1>
</div>

<div class="card">
  <div class="card-body">
    <div class="form-section">
      <form method="post" action="<?= htmlspecialchars($accion, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
          <label class="form-label" for="nombre_habilidad">Nombre</label>
          <input type="text" id="nombre_habilidad" name="nombre_habilidad" class="form-control" required
                 value="<?= htmlspecialchars($habilidad['nombre_habilidad'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="categoria_id">Categoría</label>
          <select id="categoria_id" name="categoria_id" class="form-select" required>
            <option value="">— Selecciona —</option>
            <?php foreach ($categorias as $cat): ?>
              <option value="<?= (int)$cat['id'] ?>"
                <?= (($habilidad['categoria_id'] ?? null) == $cat['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nombre'], ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Guardar
          </button>
          <a href="<?= BASE_URL ?>/admin/habilidades" class="btn btn-outline">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
