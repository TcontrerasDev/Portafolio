<?php
$esEdicion    = !empty($proyecto);
$tituloPagina = $esEdicion ? 'Editar proyecto' : 'Nuevo proyecto';
$breadcrumb   = [
  ['label' => 'Proyectos', 'url' => BASE_URL . '/admin/proyectos'],
  ['label' => $tituloPagina, 'url' => ''],
];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title"><?= $esEdicion ? 'Editar proyecto' : 'Nuevo proyecto' ?></h1>
</div>

<div class="card">
  <div class="card-body">
    <div class="form-section">
      <form method="post" action="<?= htmlspecialchars($accion, ENT_QUOTES, 'UTF-8') ?>" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
          <label class="form-label" for="nombre">Nombre</label>
          <input type="text" id="nombre" name="nombre" class="form-control" required
                 value="<?= htmlspecialchars($proyecto['nombre'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="link">Link</label>
          <input type="url" id="link" name="link" class="form-control"
                 value="<?= htmlspecialchars($proyecto['link'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="categoria_id">Categoría</label>
          <select id="categoria_id" name="categoria_id" class="form-select" required>
            <option value="">— Selecciona —</option>
            <?php foreach ($categorias as $cat): ?>
              <option value="<?= (int)$cat['id'] ?>"
                <?= (($proyecto['categoria_id'] ?? null) == $cat['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['nombre'], ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="form-group">
          <label class="form-label">Imagen</label>
          <?php if (!empty($proyecto['codigo_imagen'])): ?>
            <div class="img-preview-wrap">
              <img src="<?= BASE_URL ?>/assets/img/<?= htmlspecialchars($proyecto['codigo_imagen'], ENT_QUOTES, 'UTF-8') ?>"
                   alt="" class="img-preview">
              <span class="img-preview-name"><?= htmlspecialchars($proyecto['codigo_imagen'], ENT_QUOTES, 'UTF-8') ?></span>
            </div>
          <?php endif; ?>
          <input type="file" name="imagen" class="form-file" accept="image/webp,image/png,image/jpeg,image/avif">
          <p class="form-hint">Formatos: webp, png, jpg, avif — máx. 5 MB<?= $esEdicion ? '. Dejar vacío para conservar la imagen actual.' : '' ?></p>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Guardar
          </button>
          <a href="<?= BASE_URL ?>/admin/proyectos" class="btn btn-outline">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
