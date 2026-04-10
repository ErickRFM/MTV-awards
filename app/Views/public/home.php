<?php
$pageTitle = 'Inicio | MTV Awards';
require __DIR__ . '/../partials/header_public.php';

$heroLeadArtists = array_slice($heroArtists ?? [], 0, 3);
$heroLeadAlbums = array_slice($heroAlbums ?? [], 0, 4);
?>
<section class="hero-stage mb-4">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <div class="hero-stage__content">
        <span class="hero-kicker">MTV Awards Fanverse</span>
        <h1>El show donde cada voto prende una galaxia pop imaginaria.</h1>
        <p class="hero-copy">
          Explora artistas, albumes, canciones y nominaciones dentro de una portada con energia retro-futurista,
          visuales neon y todo el archivo musical listo para seguir creciendo.
        </p>
        <div class="hero-actions">
          <a class="btn btn-primary btn-lg" href="/nominations">Ver nominaciones</a>
          <a class="btn btn-outline-light btn-lg" href="/artists">Explorar artistas</a>
        </div>
        <div class="hero-stat-row">
          <?php foreach ($siteStats as $stat): ?>
            <div class="hero-stat-chip">
              <i class="<?= htmlspecialchars($stat['icon']) ?>"></i>
              <div>
                <strong><?= (int) $stat['value'] ?></strong>
                <span><?= htmlspecialchars($stat['label']) ?></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="hero-collage">
        <div class="hero-collage__badge">
          <img src="<?= htmlspecialchars(app_url('/img/system/mtvawardswhite.jpg')) ?>" alt="MTV Awards">
          <span>Neon Archive Live</span>
        </div>
        <?php if (empty($heroLeadArtists)): ?>
          <div class="hero-collage__placeholder">
            <p class="mb-0">Preparamos el escenario para que aqui aparezcan tus artistas destacados.</p>
          </div>
        <?php else: ?>
          <?php foreach ($heroLeadArtists as $index => $artist): ?>
            <article class="hero-collage__card hero-collage__card--<?= $index + 1 ?>">
              <img
                src="<?= htmlspecialchars(record_image_url($artist, 'photo', 'artists', '/vendor/adminlte/dist/img/avatar5.png', 'name')) ?>"
                alt="<?= htmlspecialchars($artist['name']) ?>"
              >
              <div class="hero-collage__meta">
                <span>Top spotlight</span>
                <strong><?= htmlspecialchars($artist['name']) ?></strong>
              </div>
            </article>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<section class="row mb-4">
  <div class="col-lg-4">
    <article class="story-card story-card--cyan">
      <span class="story-card__eyebrow">Escena activa</span>
      <h3><?= count($activeNominations) ?> nominaciones en juego</h3>
      <p>Las categorias activas mantienen encendido el tablero principal para que el publico vote sin perder el ritmo.</p>
    </article>
  </div>
  <div class="col-lg-4">
    <article class="story-card story-card--gold">
      <span class="story-card__eyebrow">Backstage</span>
      <h3><?= count($featuredArtists) ?> artistas dominan el radar</h3>
      <p>Las fotos y perfiles destacados se convierten en un lineup visual mas vivo desde la primera pantalla.</p>
    </article>
  </div>
  <div class="col-lg-4">
    <article class="story-card story-card--pink">
      <span class="story-card__eyebrow">Vinyl lane</span>
      <h3><?= count($featuredAlbums) ?> albumes pisan fuerte</h3>
      <p>Las portadas ahora funcionan como parte del ambiente, no solo como miniaturas perdidas en una lista.</p>
    </article>
  </div>
</section>

<section class="card public-card mb-4">
  <div class="card-body">
    <div class="section-heading">
      <div>
        <span class="section-heading__kicker">Capas imaginarias</span>
        <h2>Mini universos para darle personalidad al portal</h2>
      </div>
      <div class="section-heading__actions">
        <p class="mb-0">Son bloques narrativos y visuales que aprovechan tus assets existentes sin tocar la logica del sistema.</p>
        <button type="button" class="btn btn-outline-primary btn-sm fanverse-modal__button" data-toggle="modal" data-target="#fanverseModal">
          Abrir modal demo
        </button>
      </div>
    </div>
    <div class="row mt-4">
      <?php foreach ($fantasyMoments as $moment): ?>
        <div class="col-lg-4">
          <article class="fantasy-card">
            <div class="fantasy-card__icon"><i class="<?= htmlspecialchars($moment['icon']) ?>"></i></div>
            <h3><?= htmlspecialchars($moment['title']) ?></h3>
            <p class="mb-0"><?= htmlspecialchars($moment['description']) ?></p>
          </article>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="row">
  <div class="col-xl-7">
    <div class="card public-card mb-4">
      <div class="card-body">
        <div class="section-heading section-heading--tight">
          <div>
            <span class="section-heading__kicker">Artist spotlight</span>
            <h2>Artistas destacados</h2>
          </div>
          <a href="/artists" class="btn btn-outline-primary">Ver todos</a>
        </div>
        <?php if (empty($featuredArtists)): ?>
          <p class="text-muted mb-0">Aun no hay artistas destacados.</p>
        <?php else: ?>
          <div class="artist-feature-grid">
            <?php foreach ($featuredArtists as $artist): ?>
              <article class="artist-feature-card">
                <img
                  src="<?= htmlspecialchars(record_image_url($artist, 'photo', 'artists', '/vendor/adminlte/dist/img/avatar5.png', 'name')) ?>"
                  alt="<?= htmlspecialchars($artist['name']) ?>"
                >
                <div class="artist-feature-card__body">
                  <span class="artist-feature-card__tag"><?= htmlspecialchars($artist['nationality'] ?? 'Escena global') ?></span>
                  <h3><?= htmlspecialchars($artist['name']) ?></h3>
                  <p><?= htmlspecialchars($artist['pseudonym'] ?? 'Performance principal del fanverse') ?></p>
                  <a href="/artist?id=<?= (int) $artist['id'] ?>" class="btn btn-sm btn-outline-primary">Ver perfil</a>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-xl-5">
    <div class="card public-card mb-4">
      <div class="card-body">
        <div class="section-heading section-heading--tight">
          <div>
            <span class="section-heading__kicker">Vinyl lane</span>
            <h2>Albumes en tendencia</h2>
          </div>
          <a href="/albums" class="btn btn-outline-primary">Ver albumes</a>
        </div>
        <?php if (empty($featuredAlbums)): ?>
          <p class="text-muted mb-0">Aun no hay albumes destacados.</p>
        <?php else: ?>
          <div class="album-stack">
            <?php foreach ($featuredAlbums as $album): ?>
              <article class="album-stack__item">
                <img
                  src="<?= htmlspecialchars(record_image_url($album, 'cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'title')) ?>"
                  alt="<?= htmlspecialchars($album['title']) ?>"
                >
                <div class="album-stack__body">
                  <span><?= htmlspecialchars($album['artist_name']) ?></span>
                  <h3><?= htmlspecialchars($album['title']) ?></h3>
                  <a href="/album?id=<?= (int) $album['id'] ?>" class="btn btn-sm btn-primary">Ver album</a>
                </div>
              </article>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($heroLeadAlbums)): ?>
  <section class="card public-card public-card--compact mb-4">
    <div class="card-body">
      <div class="section-heading section-heading--tight">
        <div>
          <span class="section-heading__kicker">Cover stream</span>
          <h2>Portadas que sostienen el ambiente</h2>
        </div>
      </div>
      <div class="cover-stream">
        <?php foreach ($heroLeadAlbums as $album): ?>
          <article class="cover-stream__item">
            <img
              src="<?= htmlspecialchars(record_image_url($album, 'cover', 'albums', '/vendor/adminlte/dist/img/photo1.png', 'title')) ?>"
              alt="<?= htmlspecialchars($album['title']) ?>"
            >
            <div class="cover-stream__caption">
              <strong><?= htmlspecialchars($album['title']) ?></strong>
              <span><?= htmlspecialchars($album['artist_name'] ?? 'MTV Awards') ?></span>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<div class="modal fade fanverse-modal" id="fanverseModal" tabindex="-1" role="dialog" aria-labelledby="fanverseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <button type="button" class="fanverse-modal__close" data-dismiss="modal" aria-label="Cerrar">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="modal-body">
        <span class="fanverse-modal__eyebrow">Modal showcase</span>
        <h2 id="fanverseModalLabel">Atlas Fanverse</h2>
        <p class="fanverse-modal__lead">
          Un ejemplo de modal visual que conserva la atmosfera neon del portal sin tocar la logica principal ni romper la navegacion.
        </p>
        <div class="fanverse-modal__grid">
          <article class="fanverse-modal__card">
            <strong>Escenario</strong>
            <p>Capas de color, brillo suave y texto corto para presentar contenido destacado sin saturar la pantalla.</p>
          </article>
          <article class="fanverse-modal__card">
            <strong>Lectura movil</strong>
            <p>Espacios mas compactos, radios generosos y botones que respiran mejor en anchos pequenos.</p>
          </article>
          <article class="fanverse-modal__card">
            <strong>Coherencia</strong>
            <p>El modal toma los degradados, bordes y contrastes del sistema para verse nativo dentro del fanverse.</p>
          </article>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer_public.php'; ?>
