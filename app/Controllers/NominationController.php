<?php

require_once __DIR__ . '/../Models/Nomination.php';
require_once __DIR__ . '/../Models/NominationItem.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/Album.php';

class NominationController
{
    public function list(): void
    {
        $nominations = Nomination::all();
        require __DIR__ . '/../Views/admin/nominations_list.php';
    }

    public function createForm(array $errors = [], array $old = []): void
    {
        $nom = $old;
        require __DIR__ . '/../Views/admin/nomination_form.php';
    }

    public function store(): void
    {
        $errors = $this->validate($_POST);
        if ($errors !== []) {
            $this->createForm($errors, $_POST);
            return;
        }

        $id = Nomination::create([
            'title' => trim($_POST['title']),
            'type' => $_POST['type'],
            'category' => trim($_POST['category'] ?? ''),
            'start_date' => $this->normalizeDateTime($_POST['start_date'] ?? ''),
            'end_date' => $this->normalizeDateTime($_POST['end_date'] ?? ''),
            'status' => $_POST['status'] ?? 'active',
        ]);

        header('Location: /admin/nomination/edit?id=' . $id);
        exit;
    }

    public function editForm(int $id, array $errors = []): void
    {
        $nom = Nomination::find($id);
        if (!$nom) {
            header('Location: /admin/nominations');
            exit;
        }

        $items = NominationItem::byNomination($id);
        $artists = Artist::all();
        $albums = Album::all();

        require __DIR__ . '/../Views/admin/nomination_form.php';
    }

    public function update(int $id): void
    {
        $nom = Nomination::find($id);
        if (!$nom) {
            header('Location: /admin/nominations');
            exit;
        }

        $errors = $this->validate($_POST);
        if ($errors !== []) {
            $nom = array_merge($nom, $_POST);
            $items = NominationItem::byNomination($id);
            $artists = Artist::all();
            $albums = Album::all();
            require __DIR__ . '/../Views/admin/nomination_form.php';
            return;
        }

        Nomination::update($id, [
            'title' => trim($_POST['title']),
            'type' => $_POST['type'],
            'category' => trim($_POST['category'] ?? ''),
            'start_date' => $this->normalizeDateTime($_POST['start_date'] ?? ''),
            'end_date' => $this->normalizeDateTime($_POST['end_date'] ?? ''),
            'status' => $_POST['status'] ?? 'active',
        ]);

        header('Location: /admin/nomination/edit?id=' . $id);
        exit;
    }

    public function delete(int $id): void
    {
        Nomination::delete($id);
        header('Location: /admin/nominations');
        exit;
    }

    public function addItem(): void
    {
        $nominationId = (int) ($_POST['nomination_id'] ?? 0);
        $nom = Nomination::find($nominationId);

        if (!$nom) {
            header('Location: /admin/nominations');
            exit;
        }

        $artistId = !empty($_POST['artist_id']) ? (int) $_POST['artist_id'] : null;
        $albumId = !empty($_POST['album_id']) ? (int) $_POST['album_id'] : null;

        if ($nom['type'] === 'artist') {
            $albumId = null;
        }

        if ($nom['type'] === 'album') {
            $artistId = null;
        }

        if (!$artistId && !$albumId) {
            header('Location: /admin/nomination/edit?id=' . $nominationId);
            exit;
        }

        NominationItem::create([
            'nomination_id' => $nominationId,
            'artist_id' => $artistId,
            'album_id' => $albumId,
        ]);

        header('Location: /admin/nomination/edit?id=' . $nominationId);
        exit;
    }

    public function deleteItem(int $id): void
    {
        $item = NominationItem::find($id);
        if (!$item) {
            header('Location: /admin/nominations');
            exit;
        }

        $nominationId = (int) $item['nomination_id'];
        NominationItem::delete($id);

        header('Location: /admin/nomination/edit?id=' . $nominationId);
        exit;
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (trim($data['title'] ?? '') === '') {
            $errors[] = 'El titulo de la nominacion es obligatorio.';
        }

        if (!in_array($data['type'] ?? '', ['artist', 'album'], true)) {
            $errors[] = 'Selecciona un tipo valido.';
        }

        return $errors;
    }

    private function normalizeDateTime(string $value): ?string
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }

        return str_replace('T', ' ', $value) . ':00';
    }
}
