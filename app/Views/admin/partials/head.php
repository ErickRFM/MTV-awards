<?php
$pageTitle = $pageTitle ?? 'Panel MTV Awards';
$adminCssVersion = @filemtime(__DIR__ . '/../../../../public/css/app.css') ?: time();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($pageTitle) ?></title>
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
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/vendor/adminlte/dist/css/adminlte.min.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(app_url('/css/app.css?v=' . $adminCssVersion)) ?>">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
