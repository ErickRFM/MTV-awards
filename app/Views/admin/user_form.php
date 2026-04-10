<?php
$pageTitle = !empty($user['id']) ? 'Editar usuario | MTV Awards' : 'Nuevo usuario | MTV Awards';
$activeMenu = 'users';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
$editing = !empty($user['id']);
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1><?= $editing ? 'Editar usuario' : 'Nuevo usuario' ?></h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="<?= $editing ? '/admin/user/update' : '/admin/user/store' ?>" method="post" enctype="multipart/form-data">
            <?php if ($editing): ?>
              <input type="hidden" name="id" value="<?= (int) $user['id'] ?>">
            <?php endif; ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Usuario</label>
                  <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre a mostrar</label>
                  <input type="text" name="display_name" class="form-control" value="<?= htmlspecialchars($user['display_name'] ?? '') ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Correo</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Rol</label>
                  <select name="role_id" class="form-control" required>
                    <?php foreach ($roles as $role): ?>
                      <option value="<?= (int) $role['id'] ?>" <?= (int) ($user['role_id'] ?? 3) === (int) $role['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($role['name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Estado</label>
                  <select name="status" class="form-control">
                    <option value="1" <?= (int) ($user['status'] ?? 1) === 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= isset($user['status']) && (int) $user['status'] === 0 ? 'selected' : '' ?>>Inactivo</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label><?= $editing ? 'Nueva contrasena (opcional)' : 'Contrasena' ?></label>
                  <input type="password" name="password" class="form-control" <?= $editing ? '' : 'required' ?>>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Avatar</label>
                  <input type="file" name="avatar" class="form-control-file">
                  <?php if (!empty($user['avatar'])): ?>
                    <div class="mt-2"><img src="<?= htmlspecialchars(media_url($user['avatar'] ?? null, '/img/users/user.png', ['folder' => 'users', 'hint' => $user['display_name'] ?? $user['username'] ?? null])) ?>" class="preview-thumb rounded-circle" alt="Avatar actual"></div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <button class="btn btn-primary" type="submit"><?= $editing ? 'Actualizar usuario' : 'Crear usuario' ?></button>
            <a href="/admin/users" class="btn btn-default">Cancelar</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
