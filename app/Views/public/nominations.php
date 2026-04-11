<?php
$pageTitle = 'Nominaciones | MTV Awards';
$statusLabels = [
    'all' => 'Todas',
    'in_progress' => 'En proceso',
    'finished' => 'Finalizadas',
];
$statusHeadings = [
    'all' => 'Todas las nominaciones',
    'in_progress' => 'Nominaciones en proceso',
    'finished' => 'Nominaciones finalizadas',
];
$statusDescriptions = [
    'all' => 'Explora todas las nominaciones y revisa cuantas siguen abiertas o ya cerraron su vigencia.',
    'in_progress' => 'Estas nominaciones siguen dentro de la ventana de vigencia disponible en esta vista.',
    'finished' => 'Estas nominaciones ya cerraron su vigencia y quedan separadas del listado activo.',
];
$emptyMessages = [
    'all' => 'No hay nominaciones disponibles.',
    'in_progress' => 'No hay nominaciones en proceso por el momento.',
    'finished' => 'Aun no hay nominaciones finalizadas.',
];
$selectedStatus = $selectedStatus ?? 'all';
$totalCount = ($inProgressCount ?? 0) + ($finishedCount ?? 0);
$nominations = $filteredNominations ?? $nominations ?? [];
$tabs = [
    ['key' => 'all', 'count' => $totalCount],
    ['key' => 'in_progress', 'count' => $inProgressCount ?? 0],
    ['key' => 'finished', 'count' => $finishedCount ?? 0],
];

require __DIR__ . '/../partials/header_public.php';
?>
<div class="card nominations-view">
  <div class="card-header nominations-view__header">
    <div class="nominations-view__copy">
      <span class="nominations-view__eyebrow">Filtro de vigencia</span>
      <p class="nominations-view__summary mb-0">
        <?= htmlspecialchars($statusDescriptions[$selectedStatus] ?? $statusDescriptions['all']) ?>
        En proceso: <?= (int) ($inProgressCount ?? 0) ?> | Finalizadas: <?= (int) ($finishedCount ?? 0) ?>.
      </p>
    </div>
    <div class="nominations-tabs" role="tablist" aria-label="Filtrar nominaciones por vigencia">
      <?php foreach ($tabs as $tab): ?>
        <?php $isActive = $selectedStatus === $tab['key']; ?>
        <a
          href="/nominations<?= $tab['key'] === 'all' ? '' : '?status=' . urlencode($tab['key']) ?>"
          class="nominations-tabs__link<?= $isActive ? ' is-active' : '' ?>"
          <?= $isActive ? 'aria-current="page"' : '' ?>
        >
          <span><?= htmlspecialchars($statusLabels[$tab['key']] ?? $tab['key']) ?></span>
          <strong><?= (int) $tab['count'] ?></strong>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="card-body">
    <div class="nominations-view__metrics">
      <div class="nominations-view__metric">
        <span class="nominations-view__metric-label">Mostrando</span>
        <strong><?= count($nominations) ?></strong>
      </div>
      <div class="nominations-view__metric">
        <span class="nominations-view__metric-label">En proceso</span>
        <strong><?= (int) ($inProgressCount ?? 0) ?></strong>
      </div>
      <div class="nominations-view__metric">
        <span class="nominations-view__metric-label">Finalizadas</span>
        <strong><?= (int) ($finishedCount ?? 0) ?></strong>
      </div>
    </div>
    <div class="row">
      <?php if (empty($nominations)): ?>
        <div class="col-12">
          <div class="nominations-empty">
            <p class="mb-0"><?= htmlspecialchars($emptyMessages[$selectedStatus] ?? $emptyMessages['all']) ?></p>
          </div>
        </div>
      <?php endif; ?>
      <?php foreach ($nominations as $nomination): ?>
        <div class="col-lg-6">
          <div class="card public-card nominations-card">
            <div class="card-body">
              <div class="nominations-card__top">
                <span class="nominations-status nominations-status--<?= htmlspecialchars($nomination['display_status'] ?? 'in_progress') ?>">
                  <?= htmlspecialchars(($nomination['display_status'] ?? 'in_progress') === 'finished' ? 'Finalizada' : 'En proceso') ?>
                </span>
              </div>
              <h4><?= htmlspecialchars($nomination['title']) ?></h4>
              <p class="mb-1"><strong>Categoria:</strong> <?= htmlspecialchars($nomination['category'] ?? 'Sin categoria') ?></p>
              <p class="mb-1"><strong>Tipo:</strong> <?= htmlspecialchars(ucfirst($nomination['type'])) ?></p>
              <p class="mb-3"><strong>Vigencia:</strong> <?= htmlspecialchars(($nomination['start_date'] ?? 'Sin inicio') . ' / ' . ($nomination['end_date'] ?? 'Sin fin')) ?></p>
              <a href="/nomination?id=<?= (int) $nomination['id'] ?>" class="btn btn-primary">Ver detalle</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php require __DIR__ . '/../partials/footer_public.php'; ?>
