<?php require __DIR__ . '/../partials/head.php'; ?>
<?php require __DIR__ . '/../partials/sidebar.php'; ?>

<div class="content-wrapper">
<section class="content-header">
  <h1>Editar Nominación</h1>
</section>

<section class="content">
<form action="/admin/nomination/update" method="POST">

  <input type="hidden" name="id" value="<?= $nomination['id'] ?>">

  <div>
    <label>Título</label>
    <input type="text" name="title" value="<?= htmlspecialchars($nomination['title']) ?>" required>
  </div>

  <div>
    <label>Tipo</label>
    <select name="type">
      <option value="song" <?= $nomination['type']=='song'?'selected':'' ?>>Canción</option>
      <option value="album" <?= $nomination['type']=='album'?'selected':'' ?>>Álbum</option>
      <option value="artist" <?= $nomination['type']=='artist'?'selected':'' ?>>Artista</option>
    </select>
  </div>

  <div>
    <label>Categoría</label>
    <input type="text" name="category" value="<?= htmlspecialchars($nomination['category']) ?>">
  </div>

  <div>
    <label>Fecha inicio</label>
    <input type="datetime-local" name="start_date" value="<?= str_replace(' ','T',$nomination['start_date']) ?>">
  </div>

  <div>
    <label>Fecha fin</label>
    <input type="datetime-local" name="end_date" value="<?= str_replace(' ','T',$nomination['end_date']) ?>">
  </div>

  <div>
    <label>Estado</label>
    <select name="status">
      <option value="active" <?= $nomination['status']=='active'?'selected':'' ?>>Activa</option>
      <option value="inactive" <?= $nomination['status']=='inactive'?'selected':'' ?>>Inactiva</option>
    </select>
  </div>

  <button type="submit">Actualizar</button>
</form>
</section>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>
