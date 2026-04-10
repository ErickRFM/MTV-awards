<?php
$pageTitle = 'Editar cancion | MTV Awards';
$activeMenu = 'songs';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1>Editar cancion</h1>
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

          <form action="/admin/songs/update" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int) $songData['id'] ?>">

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Titulo</label>
                  <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($songData['title'] ?? '') ?>" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Album</label>
                  <select name="album_id" class="form-control">
                    <option value="">Sin album</option>
                    <?php foreach ($albums as $album): ?>
                      <option value="<?= (int) $album['id'] ?>" <?= (int) ($songData['album_id'] ?? 0) === (int) $album['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($album['title'] . ' - ' . $album['artist_name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Fecha de lanzamiento</label>
                  <input type="date" name="release_date" class="form-control" value="<?= htmlspecialchars($songData['release_date'] ?? '') ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Genero</label>
                  <select name="genre_id" class="form-control">
                    <option value="">Selecciona un genero</option>
                    <?php foreach ($genres as $genre): ?>
                      <option value="<?= (int) $genre['id'] ?>" <?= (int) ($songData['genre_id'] ?? 0) === (int) $genre['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($genre['name']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>URL MP3</label>
                  <input type="url" name="mp3_url" class="form-control" value="<?= htmlspecialchars($songData['mp3_url'] ?? '') ?>">
                </div>
              </div>
            </div>

            <div class="form-group">
              <label>Portada de la cancion</label>
              <div class="mb-2">
                <img
                  src="<?= htmlspecialchars(record_image_url($songData, 'cover', 'songs', '/vendor/adminlte/dist/img/photo1.png', 'title')) ?>"
                  class="preview-thumb rounded"
                  alt="Portada de cancion"
                >
              </div>
              <input type="file" name="cover" class="form-control-file" accept="image/png,image/jpeg,image/webp">
              <small class="form-text text-muted">La portada actual se conserva si no seleccionas un archivo nuevo.</small>
            </div>

            <div class="form-group">
              <label>URL videoclip o streaming</label>
              <input type="url" name="video_url" class="form-control" value="<?= htmlspecialchars($songData['video_url'] ?? '') ?>">
            </div>

            <button class="btn btn-primary" type="submit">Actualizar cancion</button>
            <a href="/admin/songs" class="btn btn-default">Cancelar</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require __DIR__ . '/../partials/footer.php'; ?>
