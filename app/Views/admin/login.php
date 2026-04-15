<?php
$loginCssVersion = @filemtime(__DIR__ . '/../../../public/css/app.css') ?: time();
$loginJsVersion = @filemtime(__DIR__ . '/../../../public/js/app.js') ?: time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Ingreso | MTV Awards</title>
  <script>
    (function () {
      try {
        var storedTheme = localStorage.getItem('mtv-theme');
        var theme = storedTheme;

        if (theme !== 'dark' && theme !== 'light') {
          var prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
          theme = prefersDark ? 'dark' : 'light';
        }

        document.documentElement.setAttribute('data-theme', theme);
      } catch (error) {
        document.documentElement.setAttribute('data-theme', 'light');
      }
    })();
  </script>
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/fontawesome-free/css/all.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/dist/css/adminlte.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/css/app.css?v=' . $loginCssVersion)) ?>">
</head>
<body class="hold-transition login-page">
<button type="button" class="theme-toggle theme-toggle--auth" data-theme-toggle aria-label="Activar modo oscuro" title="Cambiar tema">
  <i class="fas fa-moon" aria-hidden="true"></i>
  <span class="sr-only theme-toggle__label">Modo oscuro</span>
</button>
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/" class="h1"><b>MTV</b> Awards</a>
    </div>
    <div class="card-body login-card-body">
      <p class="login-box-msg">Inicia sesion para comenzar tu sesion.</p>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form action="/login" method="post">
        <div class="input-group mb-3">
          <input
            type="email"
            name="email"
            class="form-control"
            placeholder="Correo electronico"
            value="<?= htmlspecialchars($old['email'] ?? '') ?>"
            required
          >
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Contrasena" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">Acuerdate de mi</label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Iniciar sesion</button>
          </div>
        </div>
      </form>

      <p class="mb-1 mt-3">
        <a href="/">Volver al portal</a>
      </p>
      <p class="mb-0">
        <a href="/register" class="text-center">Registrate para obtener una nueva membresia.</a>
      </p>
    </div>
  </div>
</div>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/jquery/jquery.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/vendor/adminlte/dist/js/adminlte.min.js')) ?>"></script>
<script src="<?= htmlspecialchars(app_url('/js/app.js?v=' . $loginJsVersion)) ?>"></script>
</body>
</html>
