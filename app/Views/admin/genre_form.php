<?php
$pageTitle = !empty($genre['id']) ? 'Editar genero | MTV Awards' : 'Nuevo genero | MTV Awards';
$activeMenu = 'genres';
require __DIR__ . '/partials/head.php';
require __DIR__ . '/partials/sidebar.php';
$editing = !empty($genre['id']);
?>
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <h1><?= $editing ? 'Editar genero' : 'Nuevo genero' ?></h1>
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

          <form action="<?= $editing ? '/admin/genre/update' : '/admin/genre/store' ?>" method="post">
            <?php if ($editing): ?>
              <input type="hidden" name="id" value="<?= (int) $genre['id'] ?>">
            <?php endif; ?>

            <div class="form-group">
              <label>Nombre del genero</label>
              <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($genre['name'] ?? '') ?>" required>
            </div>

            <button class="btn btn-primary" type="submit"><?= $editing ? 'Actualizar genero' : 'Guardar genero' ?></button>
            <a href="/admin/genres" class="btn btn-default">Cancelar</a>
          </form>
        </div>
      </div>
    </div>
  </section>
</div>
<?php require __DIR__ . '/partials/footer.php'; ?>
