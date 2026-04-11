<?php

require_once __DIR__ . '/../Models/Nomination.php';
require_once __DIR__ . '/../Models/NominationItem.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/Album.php';
require_once __DIR__ . '/../Models/Song.php';

class PublicController
{
    public function home(): void
    {
        $activeNominations = Nomination::allActive();

        $featuredArtists = Artist::top(6);
         // ORDENAMOS POR QUE VIENEN DESORDENADOS EN TU MODELO
        $heroOrder = [1, 2, 4, 3];
        usort($featuredArtists, function ($a, $b) use ($heroOrder) {
            $posA = array_search($a['id'], $heroOrder);
            $posB = array_search($b['id'], $heroOrder);
            $posA = $posA === false ? 99 : $posA;
            $posB = $posB === false ? 99 : $posB;
            return $posA - $posB;
        });
        $heroArtists = array_slice($featuredArtists, 0, 3);
        $featuredAlbums = Album::top(6);
        $heroAlbums = array_slice($featuredAlbums !== [] ? $featuredAlbums : Album::all(), 0, 4);
        $siteStats = [
            [
                'label' => 'Artistas',
                'value' => Artist::countAll(),
                'icon' => 'fas fa-microphone-alt',
            ],
            [
                'label' => 'Albumes',
                'value' => Album::countAll(),
                'icon' => 'fas fa-compact-disc',
            ],
            [
                'label' => 'Canciones',
                'value' => Song::countAll(),
                'icon' => 'fas fa-headphones',
            ],
            [
                'label' => 'Nominaciones',
                'value' => Nomination::countAll(),
                'icon' => 'fas fa-award',
            ],
        ];
        $fantasyMoments = [
            [
                'icon' => 'fas fa-bolt',
                'title' => 'Escenario Neon Galaxy',
                'description' => 'Una dimension visual donde cada voto se convierte en rayos, humo digital y pantallas gigantes.',
            ],
            [
                'icon' => 'fas fa-satellite-dish',
                'title' => 'Radar Fanverse',
                'description' => 'Un mapa imaginario que detecta que artistas estan encendiendo mas ruido entre la audiencia.',
            ],
            [
                'icon' => 'fas fa-record-vinyl',
                'title' => 'Tunel VHS Deluxe',
                'description' => 'Portadas, flashes y loops retro para que la home se sienta mas show que listado.',
            ],
        ];
        require __DIR__ . '/../Views/public/home.php';
    }

    public function nominations(): void
    {
        $selectedStatus = $_GET['status'] ?? 'all';
        $allowedStatuses = ['all', 'in_progress', 'finished'];

        if (!in_array($selectedStatus, $allowedStatuses, true)) {
            $selectedStatus = 'all';
        }

        $now = new DateTimeImmutable('now');
        $nominations = array_map(function (array $nomination) use ($now): array {
            $nomination['display_status'] = $this->resolveNominationStatus($nomination, $now);

            return $nomination;
        }, Nomination::all());

        $inProgressCount = 0;
        $finishedCount = 0;

        foreach ($nominations as $nomination) {
            if (($nomination['display_status'] ?? 'in_progress') === 'finished') {
                $finishedCount++;
                continue;
            }

            $inProgressCount++;
        }

        if ($selectedStatus === 'all') {
            $filteredNominations = $nominations;
        } else {
            $filteredNominations = array_values(array_filter(
                $nominations,
                static fn (array $nomination): bool => ($nomination['display_status'] ?? 'in_progress') === $selectedStatus
            ));
        }

        require __DIR__ . '/../Views/public/nominations.php';
    }

    public function artists(): void
    {
        $artists = Artist::all();
        require __DIR__ . '/../Views/public/artists.php';
    }

    public function albums(): void
    {
        $albums = Album::all();
        require __DIR__ . '/../Views/public/albums.php';
    }

    public function nomination(int $id): void
    {
        $nom = Nomination::find($id);
        if (!$nom) {
            http_response_code(404);
            echo 'Nominacion no encontrada.';
            return;
        }

        $items = NominationItem::byNomination($id);
        require __DIR__ . '/../Views/public/nomination.php';
    }

    public function artist(int $id): void
    {
        $artist = Artist::find($id);
        if (!$artist) {
            http_response_code(404);
            echo 'Artista no encontrado.';
            return;
        }

        $albums = Album::findByArtist($id);
        require __DIR__ . '/../Views/public/artist.php';
    }

    public function album(int $id): void
    {
        $album = Album::find($id);
        if (!$album) {
            http_response_code(404);
            echo 'Album no encontrado.';
            return;
        }

        $songModel = new Song();
        $songs = $songModel->findByAlbum($id);
        require __DIR__ . '/../Views/public/album.php';
    }

    private function resolveNominationStatus(array $nomination, DateTimeImmutable $now): string
    {
        $endDate = $this->parseNominationDate($nomination['end_date'] ?? null);

        if ($endDate instanceof DateTimeImmutable && $endDate < $now) {
            return 'finished';
        }

        return 'in_progress';
    }

    private function parseNominationDate(?string $value): ?DateTimeImmutable
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        try {
            return new DateTimeImmutable($value);
        } catch (Exception) {
            return null;
        }
    }
}
