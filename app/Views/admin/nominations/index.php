<?php require __DIR__ . '/../partials/head.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content-header">
  <h1>Nominaciones</h1>
</section>

<section class="content">
  <a href="/admin/nomination/create" class="btn btn-primary mb-3">
    Nueva nominación
  </a>

  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th>Título</th>
        <th>Tipo</th>
        <th>Categoría</th>
        <th>Estado</th>
        <th>Vigencia</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>

      <?php if(empty($nominations)): ?>
        <tr>
          <td colspan="6">No hay nominaciones registradas</td>
        </tr>
      <?php endif; ?>

      <?php foreach($nominations as $n): ?>
        <tr>
          <td><?= htmlspecialchars($n['titulo']) ?></td>
          <td><?= ucfirst($n['tipo']) ?></td>
          <td><?= htmlspecialchars($n['categoria']) ?></td>
          <td>
            <?= $n['activa'] ? 'Activa' : 'Inactiva' ?>
          </td>
          <td>
            <?= $n['fecha_inicio'] ?> → <?= $n['fecha_fin'] ?>
          </td>
          <td>
            <a href="/admin/nomination/edit?id=<?= $n['id'] ?>" class="btn btn-sm btn-warning">
              Editar
            </a>

            <form action="/admin/nomination/delete" method="POST" style="display:inline;" data-fanverse-confirm="Eliminar esta nominacion?">
              <input type="hidden" name="id" value="<?= $n['id'] ?>">
              <button class="btn btn-sm btn-danger" type="submit">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>

    </tbody>
  </table>
</section>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

