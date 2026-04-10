<?php
$pageTitle = !empty($album['id']) ? 'Editar album | MTV Awards' : 'Nuevo album | MTV Awards';
$activeMenu = 'albums';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
$editing = !empty($album['id']);
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1><?= $editing ? 'Editar album' : 'Nuevo album' ?></h1>
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

          <form action="<?= $editing ? '/admin/album/update' : '/admin/album/store' ?>" method="post" enctype="multipart/form-data">
            <?php if ($editing): ?>
              <input type="hidden" name="id" value="<?= (int) $album['id'] ?>">
            <?php endif; ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Artista</label>
                  <select name="artist_id" class="form-control" required>
                    <option value="">Selecciona un artista</option>
                    <?php foreach ($artists as $artist): ?>
                      <option value="<?= (int) $artist['id'] ?>" <?= (int) ($album['artist_id'] ?? 0) === (int) $artist['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($artist['name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Genero</label>
                  <select name="genre_id" class="form-control">
                    <option value="">Selecciona un genero</option>
                    <?php foreach ($genres as $genre): ?>
                      <option value="<?= (int) $genre['id'] ?>" <?= (int) ($album['genre_id'] ?? 0) === (int) $genre['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre['name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-8">
                <div class="form-group">
                  <label>Titulo</label>
                  <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($album['title'] ?? '') ?>" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Fecha de lanzamiento</label>
                  <input type="date" name="release_date" class="form-control" value="<?= htmlspecialchars($album['release_date'] ?? '') ?>">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Descripcion o resena</label>
              <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($album['description'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
              <label>Caratula</label>
              <input type="file" name="cover" class="form-control-file">
              <?php if (!empty($album['cover'])): ?>
                <div class="mt-2"><img src="<?= htmlspecialchars(record_image_url($album, 'cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'title')) ?>" class="preview-thumb rounded" alt="Portada actual"></div>
              <?php endif; ?>
            </div>

            <button class="btn btn-primary" type="submit"><?= $editing ? 'Actualizar album' : 'Guardar album' ?></button>
            <a href="/admin/albums" class="btn btn-default">Cancelar</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
