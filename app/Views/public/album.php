<?php
$pageTitle = 'Album | MTV Awards';
require __DIR__ . '/../partials/header_public.php';

$albumCoverUrl = record_image_url($album, 'cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'title');
?>
<div class="row">
  <div class="col-lg-4">
    <div class="card">
      <img src="<?= htmlspecialchars($albumCoverUrl) ?>" class="card-img-top public-cover" alt="Album">
      <div class="card-body">
        <h3><?= htmlspecialchars($album['title']) ?></h3>
        <p class="mb-1"><strong>Artista:</strong> <?= htmlspecialchars($album['artist_name']) ?></p>
        <p class="mb-1"><strong>Genero:</strong> <?= htmlspecialchars($album['genre_name'] ?? 'Sin genero') ?></p>
        <p class="mb-0"><strong>Lanzamiento:</strong> <?= htmlspecialchars($album['release_date'] ?? 'Sin fecha') ?></p>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Descripcion</h3>
      </div>
      <div class="card-body">
        <p class="mb-0"><?= nl2br(htmlspecialchars($album['description'] ?? 'Sin descripcion registrada.')) ?></p>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Pistas del album</h3>
      </div>
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
          <tr>
            <th>Portada</th>
            <th>Titulo</th>
            <th>Genero</th>
            <th>Fecha</th>
            <th>Recursos</th>
          </tr>
          </thead>
          <tbody>
          <?php if (empty($songs)): ?>
            <tr><td colspan="5" class="text-center text-muted">Este album aun no tiene canciones.</td></tr>
          <?php endif; ?>
          <?php foreach ($songs as $song): ?>
            <tr>
              <td>
                <img
                  src="<?= htmlspecialchars(record_image_url($song, 'cover', 'songs', $albumCoverUrl, 'title')) ?>"
                  class="table-thumb rounded"
                  alt="<?= htmlspecialchars($song['title']) ?>"
                >
              </td>
              <td><?= htmlspecialchars($song['title']) ?></td>
              <td><?= htmlspecialchars($song['genre_name'] ?? 'Sin genero') ?></td>
              <td><?= htmlspecialchars($song['release_date'] ?? 'Sin fecha') ?></td>
              <td>
                <?php if (!empty($song['mp3_url'])): ?><a href="<?= htmlspecialchars($song['mp3_url']) ?>" target="_blank" class="btn btn-xs btn-success">MP3</a><?php endif; ?>
                <?php if (!empty($song['video_url'])): ?><a href="<?= htmlspecialchars($song['video_url']) ?>" target="_blank" class="btn btn-xs btn-danger">Video</a><?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer_public.php'; ?>
