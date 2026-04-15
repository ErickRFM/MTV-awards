<?php
$pageTitle = 'Generos | MTV Awards';
$activeMenu = 'genres';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1>Generos</h1>
      <a href="/admin/genre/create" class="btn btn-primary">Nuevo genero</a>
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
              <th>Nombre</th>
              <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($genres)): ?>
              <tr><td colspan="3" class="text-center text-muted">No hay generos registrados.</td></tr>
            <?php endif; ?>
            <?php foreach ($genres as $genre): ?>
              <tr>
                <td><?= (int) $genre['id'] ?></td>
                <td><?= htmlspecialchars($genre['name']) ?></td>
                <td>
                  <a href="/admin/genre/edit?id=<?= (int) $genre['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  <form action="/admin/genre/delete" method="post" class="d-inline" data-fanverse-confirm="Eliminar este genero?">
                    <input type="hidden" name="id" value="<?= (int) $genre['id'] ?>">
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
