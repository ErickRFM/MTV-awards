<?php
$pageTitle = 'Albumes | MTV Awards';
$activeMenu = 'albums';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1>Albumes</h1>
      <a href="/admin/album/create" class="btn btn-primary">Nuevo album</a>
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
              <th>Artista</th>
              <th>Genero</th>
              <th>Lanzamiento</th>
              <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($albums)): ?>
              <tr><td colspan="7" class="text-center text-muted">No hay albumes registrados.</td></tr>
            <?php endif; ?>
            <?php foreach ($albums as $album): ?>
              <tr>
                <td><?= (int) $album['id'] ?></td>
                <td><img src="<?= htmlspecialchars(record_image_url($album, 'cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'title')) ?>" class="table-thumb rounded" alt="Portada"></td>
                <td><?= htmlspecialchars($album['title']) ?></td>
                <td><?= htmlspecialchars($album['artist_name']) ?></td>
                <td><?= htmlspecialchars($album['genre_name'] ?? 'Sin genero') ?></td>
                <td><?= htmlspecialchars($album['release_date'] ?? 'Sin fecha') ?></td>
                <td>
                  <a href="/admin/album/edit?id=<?= (int) $album['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  <form action="/admin/album/delete" method="post" class="d-inline" data-fanverse-confirm="Eliminar este album?">
                    <input type="hidden" name="id" value="<?= (int) $album['id'] ?>">
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
