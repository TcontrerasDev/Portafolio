<?php
$tituloPagina = 'Experiencia';
$breadcrumb   = [['label' => 'Experiencia', 'url' => BASE_URL . '/tom-workspace/experiencia']];
require __DIR__ . '/../layout/header.php';
?>

<div class="page-header">
  <h1 class="page-title">Experiencia laboral</h1>
  <a href="<?= BASE_URL ?>/tom-workspace/experiencia/crear" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Nueva experiencia
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
          <th>Cargo</th>
          <th>Empresa</th>
          <th>Período</th>
          <th class="col-actions">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($experiencias as $exp): ?>
          <tr>
            <td><strong><?= htmlspecialchars($exp['cargo'], ENT_QUOTES, 'UTF-8') ?></strong></td>
            <td><?= htmlspecialchars($exp['empresa'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><span class="mono-muted"><?= htmlspecialchars($exp['periodo'], ENT_QUOTES, 'UTF-8') ?></span></td>
            <td>
              <div class="actions-cell">
                <a href="<?= BASE_URL ?>/tom-workspace/experiencia/editar/<?= (int)$exp['id'] ?>" class="btn btn-sm btn-outline btn-icon" title="Editar">
                  <i class="bi bi-pencil"></i>
                </a>
                <form method="post" action="<?= BASE_URL ?>/tom-workspace/experiencia/eliminar/<?= (int)$exp['id'] ?>"
                      data-confirm="¿Eliminar esta experiencia?">
                  <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">
                  <button class="btn btn-sm btn-danger-outline btn-icon" title="Eliminar">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
        <?php if (empty($experiencias)): ?>
          <tr><td colspan="4" class="table-empty">Sin experiencias aún</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
