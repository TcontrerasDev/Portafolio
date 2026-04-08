<?php
$tituloPagina = 'Habilidades';
$breadcrumb   = [['label' => 'Habilidades', 'url' => BASE_URL . '/admin/habilidades']];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title">Habilidades</h1>
  <a href="<?= BASE_URL ?>/admin/habilidades/crear" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Nueva habilidad
  </a>
</div>

<?php if (!empty($mensaje)): ?>
  <div class="alert alert-success">
    <i class="bi bi-check-circle"></i>
    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
  </div>
<?php endif; ?>

<div class="card">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Habilidad</th>
          <th>Categoría</th>
          <th class="col-actions">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($habilidades as $h): ?>
          <tr>
            <td class="id-cell"><?= (int)$h['id'] ?></td>
            <td><?= htmlspecialchars($h['nombre_habilidad'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><span class="badge-cat"><?= htmlspecialchars($h['nombre_categoria'] ?? '—', ENT_QUOTES, 'UTF-8') ?></span></td>
            <td>
              <div class="actions-cell">
                <a href="<?= BASE_URL ?>/admin/habilidades/editar/<?= (int)$h['id'] ?>" class="btn btn-sm btn-outline btn-icon" title="Editar">
                  <i class="bi bi-pencil"></i>
                </a>
                <form method="post" action="<?= BASE_URL ?>/admin/habilidades/eliminar/<?= (int)$h['id'] ?>"
                      onsubmit="return confirm('¿Eliminar esta habilidad?');">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">
                  <button class="btn btn-sm btn-danger-outline btn-icon" title="Eliminar">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($habilidades)): ?>
          <tr><td colspan="4" class="table-empty">Sin habilidades aún</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
