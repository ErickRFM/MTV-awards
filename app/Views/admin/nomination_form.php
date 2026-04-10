<?php
$pageTitle = !empty($nom['id']) ? 'Editar nominacion | MTV Awards' : 'Nueva nominacion | MTV Awards';
$activeMenu = 'nominations';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
$editing = !empty($nom['id']);
$startDateValue = !empty($nom['start_date']) ? date('Y-m-d\TH:i', strtotime($nom['start_date'])) : '';
$endDateValue = !empty($nom['end_date']) ? date('Y-m-d\TH:i', strtotime($nom['end_date'])) : '';
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1><?= $editing ? 'Editar nominacion' : 'Nueva nominacion' ?></h1>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-body">
          <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
              <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                  <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form action="<?= $editing ? '/admin/nomination/update' : '/admin/nomination/store' ?>" method="post">
            <?php if ($editing): ?>
              <input type="hidden" name="id" value="<?= (int) $nom['id'] ?>">
            <?php endif; ?>

            <div class="row">
              <div class="col-md-5">
                <div class="form-group">
                  <label>Titulo</label>
                  <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($nom['title'] ?? '') ?>" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Tipo</label>
                  <select name="type" class="form-control" required>
                    <option value="artist" <?= ($nom['type'] ?? '') === 'artist' ? 'selected' : '' ?>>Artista</option>
                    <option value="album" <?= ($nom['type'] ?? '') === 'album' ? 'selected' : '' ?>>Album</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Categoria</label>
                  <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($nom['category'] ?? '') ?>">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Inicio de votacion</label>
                  <input type="datetime-local" name="start_date" class="form-control" value="<?= htmlspecialchars($startDateValue) ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Fin de votacion</label>
                  <input type="datetime-local" name="end_date" class="form-control" value="<?= htmlspecialchars($endDateValue) ?>">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Estado</label>
                  <select name="status" class="form-control">
                    <option value="active" <?= ($nom['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Activa</option>
                    <option value="closed" <?= ($nom['status'] ?? '') === 'closed' ? 'selected' : '' ?>>Cerrada</option>
                    <option value="finished" <?= ($nom['status'] ?? '') === 'finished' ? 'selected' : '' ?>>Finalizada</option>
                  </select>
                </div>
              </div>
            </div>

            <button class="btn btn-primary" type="submit"><?= $editing ? 'Actualizar nominacion' : 'Guardar nominacion' ?></button>
            <a href="/admin/nominations" class="btn btn-default">Cancelar</a>
          </form>
        </div>
      </div>

      <?php if ($editing): ?>
        <div class="row">
          <div class="col-lg-5">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Agregar nominado</h3>
              </div>
              <div class="card-body">
                <form action="/admin/nomination-add-item" method="post">
                  <input type="hidden" name="nomination_id" value="<?= (int) $nom['id'] ?>">

                  <?php if (($nom['type'] ?? 'artist') === 'artist'): ?>
                    <div class="form-group">
                      <label>Artista</label>
                      <select name="artist_id" class="form-control" required>
                        <option value="">Selecciona un artista</option>
                        <?php foreach ($artists as $artist): ?>
                          <option value="<?= (int) $artist['id'] ?>"><?= htmlspecialchars($artist['name']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  <?php else: ?>
                    <div class="form-group">
                      <label>Album</label>
                      <select name="album_id" class="form-control" required>
                        <option value="">Selecciona un album</option>
                        <?php foreach ($albums as $album): ?>
                          <option value="<?= (int) $album['id'] ?>"><?= htmlspecialchars($album['title'] . ' - ' . $album['artist_name']) ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  <?php endif; ?>

                  <button class="btn btn-success" type="submit">Agregar nominado</button>
                </form>
              </div>
            </div>
          </div>

          <div class="col-lg-7">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Nominados registrados</h3>
              </div>
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nominado</th>
                    <th>Votos</th>
                    <th>Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php if (empty($items)): ?>
                    <tr><td colspan="4" class="text-center text-muted">Aun no se agregan nominados.</td></tr>
                  <?php endif; ?>
                  <?php foreach ($items as $item): ?>
                    <tr>
                      <td><?= (int) $item['id'] ?></td>
                      <td><?= htmlspecialchars($item['artist_name'] ?? $item['album_title'] ?? 'Nominado') ?></td>
                      <td><?= (int) ($item['votes_count'] ?? 0) ?></td>
                      <td>
                        <form action="/admin/nomination-item/delete" method="post" class="d-inline" data-fanverse-confirm="Eliminar este nominado?">
                          <input type="hidden" name="id" value="<?= (int) $item['id'] ?>">
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
        </div>
      <?php endif; ?>
    </div>
  </section>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
