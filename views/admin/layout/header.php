<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($tituloPagina ?? 'Admin', ENT_QUOTES, 'UTF-8') ?> — Panel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    integrity="sha384-CK2SzKma4jA5H/MXDUU7i1TqZlCFaD4T01vtyDFvPlD97JQyS+IsSh1nI2EFbpyk"
    crossorigin="anonymous">
  <link rel="stylesheet" href="<?= BASE ?>/assets/css/admin.css">
</head>
<body>
<div class="admin-shell">

  <?php require __DIR__ . '/sidebar.php'; ?>

  <div class="admin-main">
    <header class="admin-topbar">
      <nav class="topbar-breadcrumb">
        <a href="<?= BASE ?>/admin">admin</a>
        <?php if (!empty($breadcrumb)): ?>
          <span class="sep">/</span>
          <?php foreach ($breadcrumb as $idx => $item): ?>
            <?php if ($idx < count($breadcrumb) - 1): ?>
              <a href="<?= htmlspecialchars($item['url'], ENT_QUOTES, 'UTF-8') ?>"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></a>
              <span class="sep">/</span>
            <?php else: ?>
              <span class="current"><?= htmlspecialchars($item['label'], ENT_QUOTES, 'UTF-8') ?></span>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>
      </nav>
    </header>

    <main class="admin-content">
