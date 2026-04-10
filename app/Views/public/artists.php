<?php
$pageTitle = 'Artistas | MTV Awards';
require __DIR__ . '/../partials/header_public.php';
?>
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Artistas participantes</h3>
  </div>
  <div class="card-body">
    <div class="row">
      <?php if (empty($artists)): ?>
        <div class="col-12"><p class="text-muted mb-0">No hay artistas registrados.</p></div>
      <?php endif; ?>
      <?php foreach ($artists as $artist): ?>
        <div class="col-lg-4 col-md-6">
          <div class="card artist-card">
            <img src="<?= htmlspecialchars(record_image_url($artist, 'photo', 'artists', '/vendor/adminlte/dist/img/avatar5.png', 'name')) ?>" class="card-img-top public-cover" alt="Artista">
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($artist['name']) ?></h5>
              <p class="card-text"><?= htmlspecialchars($artist['pseudonym'] ?? 'Sin seudonimo') ?></p>
              <a href="/artist?id=<?= (int) $artist['id'] ?>" class="btn btn-outline-primary btn-block">Ver detalle</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer_public.php'; ?>
