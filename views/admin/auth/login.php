<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso — Panel Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    integrity="sha384-CK2SzKma4jA5H/MXDUU7i1TqZlCFaD4T01vtyDFvPlD97JQyS+IsSh1nI2EFbpyk"
    crossorigin="anonymous">
  <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body>
<div class="login-page">
  <div class="login-bg"></div>

  <div class="login-card">
    <div class="login-logo">
      <span class="eyebrow">Portfolio</span>
      <span class="title">Panel Admin</span>
      <span class="subtitle">Ingresa tus credenciales para continuar</span>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-error">
        <i class="bi bi-exclamation-circle"></i>
        <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= BASE_URL ?>/tom-workspace/login" class="login-form">
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(Csrf::token(), ENT_QUOTES, 'UTF-8') ?>">

      <div class="form-group">
        <label class="form-label" for="nombre_usuario">Usuario</label>
        <input
          type="text"
          id="nombre_usuario"
          name="nombre_usuario"
          class="form-control"
          autocomplete="username"
          required
          autofocus
        >
      </div>

      <div class="form-group">
        <label class="form-label" for="contrasena">Contraseña</label>
        <input
          type="password"
          id="contrasena"
          name="contrasena"
          class="form-control"
          autocomplete="current-password"
          required
        >
      </div>

      <button type="submit" class="btn btn-primary login-submit">
        <i class="bi bi-arrow-right-circle"></i> Entrar
      </button>
    </form>
  </div>
</div>
</body>
</html>
