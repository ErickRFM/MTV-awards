<?php
$pageTitle = 'Canciones | MTV Awards';
$activeMenu = 'songs';
require __DIR__ . '/../partials/head.php';
require __DIR__ . '/../partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1>Canciones</h1>
      <a href="/admin/songs/create" class="btn btn-primary">Nueva cancion</a>
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
              <th>Portada</th>
              <th>Titulo</th>
              <th>Album</th>
              <th>Artista</th>
              <th>Genero</th>
              <th>MP3</th>
              <th>Video</th>
              <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($songs)): ?>
              <tr><td colspan="9" class="text-center text-muted">No hay canciones registradas.</td></tr>
            <?php endif; ?>
            <?php foreach ($songs as $song): ?>
              <tr>
                <td><?= (int) $song['id'] ?></td>
                <td>
                  <img
                    src="<?= htmlspecialchars(record_image_url($song, 'cover', 'songs', record_image_url($song, 'album_cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'album_title'), 'title')) ?>"
                    class="table-thumb rounded"
                    alt="Portada de cancion"
                  >
                </td>
                <td><?= htmlspecialchars($song['title']) ?></td>
                <td><?= htmlspecialchars($song['album_title'] ?? 'Sin album') ?></td>
                <td><?= htmlspecialchars($song['artist_name'] ?? 'Sin artista') ?></td>
                <td><?= htmlspecialchars($song['genre_name'] ?? 'Sin genero') ?></td>
                <td><?= !empty($song['mp3_url']) ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-secondary">No</span>' ?></td>
                <td><?= !empty($song['video_url']) ? '<span class="badge badge-success">Si</span>' : '<span class="badge badge-secondary">No</span>' ?></td>
                <td>
                  <a href="/admin/songs/edit?id=<?= (int) $song['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  <form action="/admin/songs/delete" method="post" class="d-inline" data-fanverse-confirm="Eliminar esta cancion?">
                    <input type="hidden" name="id" value="<?= (int) $song['id'] ?>">
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
<?php require __DIR__ . '/../partials/footer.php'; ?>
