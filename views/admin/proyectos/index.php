<?php
$tituloPagina = 'Proyectos';
$breadcrumb   = [['label' => 'Proyectos', 'url' => BASE_URL . '/tom-workspace/proyectos']];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title">Proyectos</h1>
  <a href="<?= BASE_URL ?>/tom-workspace/proyectos/crear" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Nuevo proyecto
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
          <th>Imagen</th>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Link</th>
          <th class="col-actions">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($proyectos as $p): ?>
          <tr>
            <td>
              <?php if (!empty($p['codigo_imagen'])): ?>
                <img src="<?= BASE_URL ?>/assets/img/<?= htmlspecialchars($p['codigo_imagen'], ENT_QUOTES, 'UTF-8') ?>"
                     alt="" class="table-img">
              <?php else: ?>
                <div class="table-img table-img-placeholder">
                  <i class="bi bi-image"></i>
                </div>
              <?php endif; ?>
            </td>
            <td><strong><?= htmlspecialchars($p['nombre'], ENT_QUOTES, 'UTF-8') ?></strong></td>
            <td><span class="badge-cat"><?= htmlspecialchars($p['nombre_categoria'] ?? '—', ENT_QUOTES, 'UTF-8') ?></span></td>
            <td>
              <?php if (!empty($p['link'])): ?>
                <a href="<?= htmlspecialchars($p['link'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener"
                   class="mono-muted">
                  <i class="bi bi-box-arrow-up-right"></i> ver
                </a>
              <?php else: ?>
                <span class="mono-muted">—</span>
              <?php endif; ?>
            </td>
            <td>
              <div class="actions-cell">
                <a href="<?= BASE_URL ?>/tom-workspace/proyectos/editar/<?= (int)$p['id'] ?>" class="btn btn-sm btn-outline btn-icon" title="Editar">
                  <i class="bi bi-pencil"></i>
                </a>
                <form method="post" action="<?= BASE_URL ?>/tom-workspace/proyectos/eliminar/<?= (int)$p['id'] ?>"
                      data-confirm="¿Eliminar este proyecto?">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">
                  <button class="btn btn-sm btn-danger-outline btn-icon" title="Eliminar">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($proyectos)): ?>
          <tr><td colspan="5" class="table-empty">Sin proyectos aún</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
