<?php
$pageTitle = 'Detalle de nominacion | MTV Awards';
require __DIR__ . '/../partials/header_public.php';
$isVotingActive = ($nom['status'] ?? '') === 'active';
?>
<div class="card">
  <div class="card-body">
    <h2><?= htmlspecialchars($nom['title']) ?></h2>
    <p class="mb-1"><strong>Categoria:</strong> <?= htmlspecialchars($nom['category'] ?? 'Sin categoria') ?></p>
    <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars(ucfirst($nom['type'])) ?></p>
    <p class="mb-0"><strong>Periodo:</strong> <?= htmlspecialchars(($nom['start_date'] ?? 'Sin inicio') . ' / ' . ($nom['end_date'] ?? 'Sin fin')) ?></p>
  </div>
</div>

<?php if (empty($_SESSION['user'])): ?>
  <div class="alert alert-warning">
    Debes <a href="/login">iniciar sesion</a> o <a href="/register">registrarte</a> para votar.
  </div>
<?php endif; ?>

<div class="row">
  <?php if (empty($items)): ?>
    <div class="col-12"><p class="text-muted">Esta nominacion aun no tiene nominados.</p></div>
  <?php endif; ?>
  <?php foreach ($items as $item): ?>
    <?php
      $name = $item['artist_name'] ?? $item['album_title'] ?? 'Nominado';
      $subtitle = $item['album_artist_name'] ?? (($nom['type'] ?? 'artist') === 'artist' ? 'Artista nominado' : 'Album nominado');
      $image = !empty($item['artist_name'])
          ? media_url($item['artist_photo'] ?? null, '/vendor/adminlte/dist/img/avatar5.png', ['folder' => 'artists', 'hint' => $item['artist_name']])
          : media_url($item['album_cover'] ?? null, '/vendor/adminlte/dist/img/photo1.png', ['folder' => 'albums', 'hint' => $item['album_title'] ?? null]);
    ?>
    <div class="col-lg-6">
      <div class="card card-outline card-primary">
        <img src="<?= htmlspecialchars($image) ?>" class="card-img-top public-cover-sm" alt="Nominado">
        <div class="card-body">
          <h4><?= htmlspecialchars($name) ?></h4>
          <p class="text-muted"><?= htmlspecialchars($subtitle) ?></p>
          <p><strong>Votos:</strong> <?= (int) ($item['votes_count'] ?? 0) ?></p>
          <button class="btn btn-success" <?= $isVotingActive ? '' : 'disabled' ?> onclick="vote(<?= (int) $nom['id'] ?>, <?= (int) $item['id'] ?>)">
            Votar
          </button>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php require __DIR__ . '/../partials/footer_public.php'; ?>
