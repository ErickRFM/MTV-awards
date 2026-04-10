<?php
$pageTitle = 'Albumes | MTV Awards';
require __DIR__ . '/../partials/header_public.php';
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Albumes registrados</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <?php if (empty($albums)): ?>
        <div class="col-12"><p class="text-muted mb-0">No hay albumes registrados.</p></div>
      <?php endif; ?>
      <?php foreach ($albums as $album): ?>
        <div class="col-lg-4 col-md-6">
          <div class="card artist-card">
            <img src="<?= htmlspecialchars(record_image_url($album, 'cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'title')) ?>" class="card-img-top public-cover" alt="Album">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($album['title']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($album['artist_name']) ?></p>
              <a href="/album?id=<?= (int) $album['id'] ?>" class="btn btn-outline-primary btn-block">Ver album</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer_public.php'; ?>
