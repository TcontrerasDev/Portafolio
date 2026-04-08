<?php
$tituloPagina = 'Categorías de habilidades';
$breadcrumb   = [['label' => 'Categorías habilidades', 'url' => BASE . '/admin/categorias']];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title">Categorías <span class="page-title-sub">/ habilidades</span></h1>
  <a href="<?= BASE ?>/admin/categorias/crear" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Nueva categoría
  </a>
</div>

<?php if (!empty($mensaje)): ?>
  <div class="alert <?= str_contains($mensaje, 'No se puede') ? 'alert-warning' : 'alert-success' ?>">
    <i class="bi bi-<?= str_contains($mensaje, 'No se puede') ? 'exclamation-triangle' : 'check-circle' ?>"></i>
    <?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?>
  </div>
<?php endif; ?>

<div class="card">
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre</th>
          <th class="col-actions">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categorias as $cat): ?>
          <tr>
            <td class="id-cell"><?= (int)$cat['id'] ?></td>
            <td><?= htmlspecialchars($cat['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
            <td>
              <div class="actions-cell">
                <a href="<?= BASE ?>/admin/categorias/editar/<?= (int)$cat['id'] ?>" class="btn btn-sm btn-outline btn-icon" title="Editar">
                  <i class="bi bi-pencil"></i>
                </a>
                <form method="post" action="<?= BASE ?>/admin/categorias/eliminar/<?= (int)$cat['id'] ?>" class="d-inline"
                      onsubmit="return confirm('¿Eliminar esta categoría?');">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">
                  <button class="btn btn-sm btn-danger-outline btn-icon" title="Eliminar">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($categorias)): ?>
          <tr><td colspan="3" class="table-empty">Sin categorías aún</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
