<?php
$pageTitle = 'Nominaciones | MTV Awards';
$activeMenu = 'nominations';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid d-flex justify-content-between align-items-center">
      <h1>Nominaciones</h1>
      <a href="/admin/nomination/create" class="btn btn-primary">Nueva nominacion</a>
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
              <th>Titulo</th>
              <th>Tipo</th>
              <th>Categoria</th>
              <th>Vigencia</th>
              <th>Estado</th>
              <th>Nominados</th>
              <th>Votos</th>
              <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            <?php if (empty($nominations)): ?>
              <tr><td colspan="9" class="text-center text-muted">No hay nominaciones registradas.</td></tr>
            <?php endif; ?>
            <?php foreach ($nominations as $nomination): ?>
              <tr>
                <td><?= (int) $nomination['id'] ?></td>
                <td><?= htmlspecialchars($nomination['title']) ?></td>
                <td><?= htmlspecialchars(ucfirst($nomination['type'])) ?></td>
                <td><?= htmlspecialchars($nomination['category'] ?? 'Sin categoria') ?></td>
                <td><?= htmlspecialchars(($nomination['start_date'] ?? 'Sin inicio') . ' / ' . ($nomination['end_date'] ?? 'Sin fin')) ?></td>
                <td><span class="badge badge-info"><?= htmlspecialchars($nomination['status']) ?></span></td>
                <td><?= (int) ($nomination['nominees_count'] ?? 0) ?></td>
                <td><?= (int) ($nomination['votes_count'] ?? 0) ?></td>
                <td>
                  <a href="/admin/nomination/edit?id=<?= (int) $nomination['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                  <form action="/admin/nomination/delete" method="post" class="d-inline" data-fanverse-confirm="Eliminar esta nominacion?">
                    <input type="hidden" name="id" value="<?= (int) $nomination['id'] ?>">
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
