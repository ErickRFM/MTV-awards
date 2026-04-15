<?php
$user = $_SESSION['user'] ?? null;
$activeMenu = $activeMenu ?? '';
$roleId = (int) ($user['role_id'] ?? 0);
?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <li class="nav-item">
      <button type="button" class="nav-link theme-toggle theme-toggle--admin" data-theme-toggle aria-label="Activar modo oscuro" title="Cambiar tema">
        <i class="fas fa-moon" aria-hidden="true"></i>
        <span class="sr-only theme-toggle__label">Modo oscuro</span>
      </button>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/" target="_blank">Ver portal</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="/logout">Salir</a>
    </li>
  </ul>
</nav>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="/admin/dashboard" class="brand-link admin-brand">
    <img src="<?= htmlspecialchars(app_url('/img/system/mtv-logo.jpg')) ?>" alt="MTV Awards" class="brand-image elevation-3 admin-brand__logo">
    <span class="brand-text font-weight-light">MTV Awards</span>
  </a>

  <div class="sidebar">
    <?php if ($user): ?>
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img
            src="<?= htmlspecialchars(media_url($user['avatar'] ?? null, '/vendor/adminlte/dist/img/avatar5.png', ['folder' => 'users', 'hint' => $user['display_name'] ?? $user['username'] ?? null, 'extra' => ['uploads/users/user.png', 'img/users/user.png']])) ?>"
            class="img-circle elevation-2"
            alt="Usuario"
          >
        </div>
        <div class="info">
          <a href="/admin/dashboard" class="d-block"><?= htmlspecialchars($user['display_name'] ?? $user['username'] ?? 'Usuario') ?></a>
          <small class="text-muted"><?= htmlspecialchars($user['role_name'] ?? 'Administrador') ?></small>
        </div>
      </div>
    <?php endif; ?>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
        <li class="nav-item">
          <a href="/admin/dashboard" class="nav-link <?= $activeMenu === 'dashboard' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <?php if ($roleId === 1): ?>
          <li class="nav-item">
            <a href="/admin/users" class="nav-link <?= $activeMenu === 'users' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php endif; ?>
        <li class="nav-item">
          <a href="/admin/artists" class="nav-link <?= $activeMenu === 'artists' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-user-music"></i>
            <p>Artistas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/albums" class="nav-link <?= $activeMenu === 'albums' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-compact-disc"></i>
            <p>Albumes</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/genres" class="nav-link <?= $activeMenu === 'genres' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-tags"></i>
            <p>Generos</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/admin/songs" class="nav-link <?= $activeMenu === 'songs' ? 'active' : '' ?>">
            <i class="nav-icon fas fa-music"></i>
            <p>Canciones</p>
          </a>
        </li>
        <?php if ($roleId === 1): ?>
          <li class="nav-item">
            <a href="/admin/nominations" class="nav-link <?= $activeMenu === 'nominations' ? 'active' : '' ?>">
              <i class="nav-icon fas fa-award"></i>
              <p>Nominaciones</p>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</aside>
