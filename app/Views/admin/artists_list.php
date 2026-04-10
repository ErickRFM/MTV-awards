<?php
$pageTitle = 'Artistas | MTV Awards';
$activeMenu = 'artists';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1>Artistas</h1>
      <a href="/admin/artist/create" class="btn btn-primary">Nuevo artista</a>
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
              <th>Foto</th>
              <th>Nombre</th>
              <th>Seudonimo</th>
              <th>Nacionalidad</th>
              <th>Estado</th>
              <th>Albumes</th>
              <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($artists)): ?>
              <tr><td colspan="8" class="text-center text-muted">Todavia no hay artistas.</td></tr>
            <?php endif; ?>
            <?php foreach ($artists as $artist): ?>
              <tr>
                <td><?= (int) $artist['id'] ?></td>
                <td><img src="<?= htmlspecialchars(record_image_url($artist, 'photo', 'artists', '/vendor/adminlte/dist/img/avatar5.png', 'name')) ?>" class="table-thumb rounded" alt="Artista"></td>
                <td><?= htmlspecialchars($artist['name']) ?></td>
                <td><?= htmlspecialchars($artist['pseudonym'] ?? 'Sin seudonimo') ?></td>
                <td><?= htmlspecialchars($artist['nationality'] ?? 'Sin dato') ?></td>
                <td><span class="badge badge-<?= (int) $artist['status'] === 1 ? 'success' : 'secondary' ?>"><?= (int) $artist['status'] === 1 ? 'Activo' : 'Retirado' ?></span></td>
                <td><?= (int) ($artist['albums_count'] ?? 0) ?></td>
                <td>
                  <a href="/admin/artist/edit?id=<?= (int) $artist['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  <form action="/admin/artist/delete" method="post" class="d-inline" data-fanverse-confirm="Eliminar este artista?">
                    <input type="hidden" name="id" value="<?= (int) $artist['id'] ?>">
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
<?php require __DIR__ . '/partials/footer.php'; ?>
