<?php
$esEdicion    = !empty($experiencia);
$tituloPagina = $esEdicion ? 'Editar experiencia' : 'Nueva experiencia';
$breadcrumb   = [
  ['label' => 'Experiencia', 'url' => BASE_URL . '/admin/experiencia'],
  ['label' => $tituloPagina, 'url' => ''],
];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title"><?= $esEdicion ? 'Editar experiencia' : 'Nueva experiencia' ?></h1>
</div>

<div class="card">
  <div class="card-body">
    <div class="form-section">
      <form method="post" action="<?= htmlspecialchars($accion, ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
          <label class="form-label" for="cargo">Cargo</label>
          <input type="text" id="cargo" name="cargo" class="form-control" required
                 value="<?= htmlspecialchars($experiencia['cargo'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="empresa">Empresa</label>
          <input type="text" id="empresa" name="empresa" class="form-control" required
                 value="<?= htmlspecialchars($experiencia['empresa'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="periodo">Período</label>
          <input type="text" id="periodo" name="periodo" class="form-control" required
                 placeholder="Ej: 2022 – 2024"
                 value="<?= htmlspecialchars($experiencia['periodo'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>

        <div class="form-group">
          <label class="form-label" for="descripcion">Descripción</label>
          <textarea id="descripcion" name="descripcion" class="form-textarea" rows="4" required><?= htmlspecialchars($experiencia['descripcion'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="form-actions">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg"></i> Guardar
          </button>
          <a href="<?= BASE_URL ?>/admin/experiencia" class="btn btn-outline">Cancelar</a>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
