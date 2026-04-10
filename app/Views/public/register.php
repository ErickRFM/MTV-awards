<?php
$registerCssVersion = @filemtime(__DIR__ . '/../../../public/css/app.css') ?: time();
$registerJsVersion = @filemtime(__DIR__ . '/../../../public/js/app.js') ?: time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro | MTV Awards</title>
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/fontawesome-free/css/all.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/dist/css/adminlte.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/css/app.css?v=' . $registerCssVersion)) ?>">
</head>
<body class="hold-transition register-page">
<div class="register-box">
  <div class="register-logo">
    <a href="/"><b>MTV</b> Awards</a>
  </div>
  <div class="card card-outline card-primary">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Crea tu cuenta de audiencia para votar</p>

      <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
              <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="/register" method="post">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Usuario" value="<?= htmlspecialchars($old['username'] ?? '') ?>" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-user"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="text" name="display_name" class="form-control" placeholder="Nombre a mostrar" value="<?= htmlspecialchars($old['display_name'] ?? '') ?>">
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-id-badge"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Correo" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Contrasena" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password_confirmation" class="form-control" placeholder="Confirma la contrasena" required>
          <div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>
        </div>
        <div class="row">
          <div class="col-5">
            <a href="/" class="btn btn-default btn-block">Volver</a>
          </div>
          <div class="col-7">
            <button type="submit" class="btn btn-primary btn-block">Registrarme</button>
          </div>
        </div>
      </form>

      <a href="/login" class="text-center d-block mt-3">Ya tengo cuenta</a>
    </div>
  </div>
</div>
<script src="<?= htmlspecialchars(app_url('/js/app.js?v=' . $registerJsVersion)) ?>"></script>
</body>
</html>
