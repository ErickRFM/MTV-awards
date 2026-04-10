<?php
$pageTitle = 'Dashboard | MTV Awards';
$activeMenu = 'dashboard';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Dashboard</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <?php
        $cards = [
            ['label' => 'Usuarios', 'icon' => 'fas fa-users', 'color' => 'bg-primary', 'value' => $stats['users']],
            ['label' => 'Artistas', 'icon' => 'fas fa-user-music', 'color' => 'bg-info', 'value' => $stats['artists']],
            ['label' => 'Albumes', 'icon' => 'fas fa-compact-disc', 'color' => 'bg-success', 'value' => $stats['albums']],
            ['label' => 'Canciones', 'icon' => 'fas fa-music', 'color' => 'bg-warning', 'value' => $stats['songs']],
            ['label' => 'Nominaciones', 'icon' => 'fas fa-award', 'color' => 'bg-danger', 'value' => $stats['nominations']],
            ['label' => 'Votos', 'icon' => 'fas fa-vote-yea', 'color' => 'bg-secondary', 'value' => $stats['votes']],
        ];
        ?>
        <?php foreach ($cards as $card): ?>
          <div class="col-lg-4 col-md-6">
            <div class="small-box <?= $card['color'] ?>">
              <div class="inner">
                <h3><?= (int) $card['value'] ?></h3>
                <p><?= htmlspecialchars($card['label']) ?></p>
              </div>
              <div class="icon">
                <i class="<?= $card['icon'] ?>"></i>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="row">
        <div class="col-lg-7">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Nominaciones recientes</h3>
            </div>
            <div class="card-body table-responsive p-0">
              <table class="table table-hover text-nowrap">
                <thead>
                <tr>
                  <th>Titulo</th>
                  <th>Tipo</th>
                  <th>Categoria</th>
                  <th>Estado</th>
                  <th>Votos</th>
                </tr>
                </thead>
                <tbody>
                <?php if (empty($recentNominations)): ?>
                  <tr><td colspan="5" class="text-center text-muted">Aun no hay nominaciones registradas.</td></tr>
                <?php endif; ?>
                <?php foreach ($recentNominations as $nomination): ?>
                  <tr>
                    <td><?= htmlspecialchars($nomination['title']) ?></td>
                    <td><?= htmlspecialchars(ucfirst($nomination['type'])) ?></td>
                    <td><?= htmlspecialchars($nomination['category'] ?? 'Sin categoria') ?></td>
                    <td><span class="badge badge-pill badge-info"><?= htmlspecialchars($nomination['status']) ?></span></td>
                    <td><?= (int) ($nomination['votes_count'] ?? 0) ?></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-5">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Artistas destacados</h3>
            </div>
            <div class="card-body">
              <?php if (empty($popularArtists)): ?>
                <p class="text-muted mb-0">No hay artistas con votos todavia.</p>
              <?php endif; ?>

              <?php foreach ($popularArtists as $artist): ?>
                <div class="d-flex align-items-center mb-3">
                  <img src="<?= !empty($artist['photo']) ? '/' . ltrim($artist['photo'], '/') : '/vendor/adminlte/dist/img/avatar5.png' ?>" class="img-circle elevation-1 mr-3 artist-thumb" alt="Artista">
                  <div>
                    <strong><?= htmlspecialchars($artist['name']) ?></strong>
                    <div class="text-muted small"><?= (int) ($artist['votes_count'] ?? 0) ?> votos</div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
