<?php
$pageTitle = 'Artista | MTV Awards';
require __DIR__ . '/../partials/header_public.php';
?>
<div class="row">
  <div class="col-lg-4">
    <div class="card">
      <img src="<?= htmlspecialchars(record_image_url($artist, 'photo', 'artists', '/vendor/adminlte/dist/img/avatar5.png', 'name')) ?>" class="card-img-top public-cover" alt="Artista">
      <div class="card-body">
        <h3><?= htmlspecialchars($artist['name']) ?></h3>
        <p class="mb-1"><strong>Seudonimo:</strong> <?= htmlspecialchars($artist['pseudonym'] ?? 'Sin seudonimo') ?></p>
        <p class="mb-1"><strong>Nacionalidad:</strong> <?= htmlspecialchars($artist['nationality'] ?? 'Sin dato') ?></p>
        <p class="mb-0"><strong>Estado:</strong> <?= (int) $artist['status'] === 1 ? 'Activo' : 'Retirado' ?></p>
      </div>
    </div>
  </div>
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Biografia</h3>
      </div>
      <div class="card-body">
        <p class="mb-0"><?= nl2br(htmlspecialchars($artist['biography'] ?? 'Sin biografia registrada.')) ?></p>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Discografia</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <?php if (empty($albums)): ?>
            <div class="col-12"><p class="text-muted mb-0">Este artista aun no tiene albumes registrados.</p></div>
          <?php endif; ?>
          <?php foreach ($albums as $album): ?>
            <div class="col-md-6">
              <div class="card card-outline card-info">
                <img src="<?= htmlspecialchars(record_image_url($album, 'cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'title')) ?>" class="card-img-top public-cover-sm" alt="Album">
                <div class="card-body">
                  <h5><?= htmlspecialchars($album['title']) ?></h5>
                  <p class="mb-2"><?= htmlspecialchars($album['release_date'] ?? 'Sin fecha') ?></p>
                  <a href="/album?id=<?= (int) $album['id'] ?>" class="btn btn-outline-primary btn-sm">Ver album</a>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer_public.php'; ?>
