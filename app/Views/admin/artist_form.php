<?php
$pageTitle = !empty($artist['id']) ? 'Editar artista | MTV Awards' : 'Nuevo artista | MTV Awards';
$activeMenu = 'artists';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
$editing = !empty($artist['id']);
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1><?= $editing ? 'Editar artista' : 'Nuevo artista' ?></h1>
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

          <form action="<?= $editing ? '/admin/artist/update' : '/admin/artist/store' ?>" method="post" enctype="multipart/form-data">
            <?php if ($editing): ?>
              <input type="hidden" name="id" value="<?= (int) $artist['id'] ?>">
            <?php endif; ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Nombre completo</label>
                  <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($artist['name'] ?? '') ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Seudonimo artistico</label>
                  <input type="text" name="pseudonym" class="form-control" value="<?= htmlspecialchars($artist['pseudonym'] ?? '') ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Sexo</label>
                  <select name="sex" class="form-control">
                    <option value="">Selecciona</option>
                    <option value="M" <?= ($artist['sex'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                    <option value="F" <?= ($artist['sex'] ?? '') === 'F' ? 'selected' : '' ?>>Femenino</option>
                    <option value="Otro" <?= ($artist['sex'] ?? '') === 'Otro' ? 'selected' : '' ?>>Otro</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Nacionalidad</label>
                  <input type="text" name="nationality" class="form-control" value="<?= htmlspecialchars($artist['nationality'] ?? '') ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Estado</label>
                  <select name="status" class="form-control">
                    <option value="1" <?= (int) ($artist['status'] ?? 1) === 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= isset($artist['status']) && (int) $artist['status'] === 0 ? 'selected' : '' ?>>Retirado</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Biografia</label>
              <textarea name="biography" class="form-control" rows="5"><?= htmlspecialchars($artist['biography'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
              <label>Foto del artista</label>
              <input type="file" name="photo" class="form-control-file">
              <?php if (!empty($artist['photo'])): ?>
                <div class="mt-2"><img src="<?= htmlspecialchars(record_image_url($artist, 'photo', 'artists', '/vendor/adminlte/dist/img/avatar5.png', 'name')) ?>" class="preview-thumb rounded" alt="Foto actual"></div>
              <?php endif; ?>
            </div>

            <button class="btn btn-primary" type="submit"><?= $editing ? 'Actualizar artista' : 'Guardar artista' ?></button>
            <a href="/admin/artists" class="btn btn-default">Cancelar</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
