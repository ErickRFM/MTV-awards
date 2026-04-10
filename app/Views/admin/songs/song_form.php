
<?php
// app/Views/admin/song_form.php
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/sidebar.php';
$editing = !empty($song) && !empty($song['id']);
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1><?= $editing ? 'Editar canción' : 'Nueva canción' ?></h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">

          <form method="post" action="<?= $editing ? '/admin/song/update' : '/admin/song/store' ?>">

            <?php if($editing): ?>
              <input type="hidden" name="id" value="<?= $song['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
              <label>Álbum</label>
              <select name="album_id" class="form-control">
                <option value="">--</option>
                <?php foreach($albums as $al): ?>
                  <option value="<?= $al['id'] ?>"
                    <?= isset($song['album_id']) && $song['album_id'] == $al['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($al['title']) ?> (<?= htmlspecialchars($al['artist_name'] ?? '') ?>)
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group">
              <label>Título</label>
              <input class="form-control" name="title" value="<?= htmlspecialchars($song['title'] ?? '') ?>" required>
            </div>

            <div class="form-group">
              <label>Fecha</label>
              <input type="date" name="release_date" class="form-control"
                value="<?= htmlspecialchars($song['release_date'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label>MP3 URL</label>
              <input class="form-control" name="mp3_url"
                value="<?= htmlspecialchars($song['mp3_url'] ?? '') ?>">
            </div>

            <div class="form-group">
              <label>Video URL</label>
              <input class="form-control" name="video_url"
                value="<?= htmlspecialchars($song['video_url'] ?? '') ?>">
            </div>

            <div class="form-group">
              <button class="btn btn-primary"><?= $editing ? 'Actualizar' : 'Crear' ?></button>
              <a href="/admin/songs" class="btn btn-secondary">Cancelar</a>
            </div>

          </form>

        </div>
      </div>
    </div>
  </section>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
