<?php
$pageTitle = 'Usuarios | MTV Awards';
$activeMenu = 'users';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1>Usuarios</h1>
      <a href="/admin/user/create" class="btn btn-primary">Nuevo usuario</a>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
            <tr>
              <th>ID</th>
              <th>Avatar</th>
              <th>Usuario</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Rol</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($users)): ?>
              <tr><td colspan="8" class="text-center text-muted">No hay usuarios registrados.</td></tr>
            <?php endif; ?>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= (int) $user['id'] ?></td>
                <td><img src="<?= htmlspecialchars(media_url($user['avatar'] ?? null, '/img/users/user.png', ['folder' => 'users', 'hint' => $user['display_name'] ?? $user['username'] ?? null])) ?>" class="table-thumb rounded-circle" alt="Avatar"></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td><?= htmlspecialchars($user['display_name'] ?? $user['username']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role_name'] ?? 'Sin rol') ?></td>
                <td><span class="badge badge-<?= (int) $user['status'] === 1 ? 'success' : 'secondary' ?>"><?= (int) $user['status'] === 1 ? 'Activo' : 'Inactivo' ?></span></td>
                <td>
                  <a href="/admin/user/edit?id=<?= (int) $user['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  <form action="/admin/user/delete" method="post" class="d-inline" data-fanverse-confirm="Eliminar este usuario?">
                    <input type="hidden" name="id" value="<?= (int) $user['id'] ?>">
                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
