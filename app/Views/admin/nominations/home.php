<?php require __DIR__ . '/../partials/header_public.php'; ?>

<h1>Nominaciones disponibles</h1>

<div class="row">
<?php if (empty($nominations)): ?>
  <p>No hay nominaciones activas</p>
<?php endif; ?>

<?php foreach ($nominations as $n): ?>
  <div class="col-md-6">
    <div class="card mb-3">
      <div class="card-body">
        <h5><?= htmlspecialchars($n['title']) ?></h5>
        <p><?= htmlspecialchars($n['category']) ?></p>
        <p><?= $n['start_date'] ?> → <?= $n['end_date'] ?></p>
        <a href="/nomination?id=<?= $n['id'] ?>" class="btn btn-primary">Ver / Votar</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>

<?php require __DIR__ . '/../partials/footer_public.php'; ?>
