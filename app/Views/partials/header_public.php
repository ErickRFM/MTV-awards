<?php
$sessionUser = $_SESSION['user'] ?? null;
$publicCssVersion = @filemtime(__DIR__ . '/../../../public/css/app.css') ?: time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle ?? 'MTV Awards') ?></title>
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/plugins/fontawesome-free/css/all.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/dist/css/adminlte.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/css/app.css?v=' . $publicCssVersion)) ?>">
</head>
<body class="hold-transition layout-top-nav public-site">
<div class="wrapper">
  <nav class="main-header navbar navbar-expand-md navbar-white navbar-light public-navbar">
    <div class="container">
      <a href="/" class="navbar-brand public-brand">
        <img src="<?= htmlspecialchars(app_url('/img/system/mtv-logo.jpg')) ?>" alt="MTV Awards" class="brand-logo-img">
        <span class="brand-copy">
          <span class="brand-text font-weight-bold">MTV Awards</span>
          <small class="brand-subtitle">Fanverse Edition</small>
        </span>
      </a>
      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item"><a href="/" class="nav-link">Inicio</a></li>
          <li class="nav-item"><a href="/nominations" class="nav-link">Nominaciones</a></li>
          <li class="nav-item"><a href="/artists" class="nav-link">Artistas</a></li>
          <li class="nav-item"><a href="/albums" class="nav-link">Albumes</a></li>
        </ul>
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
          <?php if ($sessionUser): ?>
            <?php if ((int) ($sessionUser['role_id'] ?? 0) === 1 || (int) ($sessionUser['role_id'] ?? 0) === 2): ?>
              <li class="nav-item"><a href="/admin/dashboard" class="nav-link">Panel</a></li>
            <?php endif; ?>
            <li class="nav-item"><a href="/logout" class="nav-link">Salir</a></li>
          <?php else: ?>
            <li class="nav-item"><a href="/register" class="nav-link">Registro</a></li>
            <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="content pt-4">
      <div class="container">
