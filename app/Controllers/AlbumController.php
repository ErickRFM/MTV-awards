<?php

require_once __DIR__ . '/../Models/Album.php';
require_once __DIR__ . '/../Models/Artist.php';
require_once __DIR__ . '/../Models/Genre.php';

class AlbumController
{
    protected array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
    }

    public function list(): void
    {
        $albums = Album::all();
        require __DIR__ . '/../Views/admin/albums_list.php';
    }

    public function createForm(array $errors = [], array $old = []): void
    {
        $album = $old;
        $artists = Artist::all();
        $genres = Genre::all();
        require __DIR__ . '/../Views/admin/album_form.php';
    }

    public function store(): void
    {
        $errors = $this->validate($_POST);
        if ($errors !== []) {
            $this->createForm($errors, $_POST);
            return;
        }

        $cover = $this->handleUpload($_FILES['cover'] ?? null, 'albums');

        Album::create([
            'artist_id' => (int) $_POST['artist_id'],
            'title' => trim($_POST['title']),
            'release_date' => $_POST['release_date'] ?? null,
            'description' => trim($_POST['description'] ?? ''),
            'cover' => $cover,
            'genre_id' => $_POST['genre_id'] ?? null,
        ]);

        header('Location: /admin/albums');
        exit;
    }

    public function editForm(int $id, array $errors = []): void
    {
        $album = Album::find($id);
        if (!$album) {
            header('Location: /admin/albums');
            exit;
        }

        $artists = Artist::all();
        $genres = Genre::all();
        require __DIR__ . '/../Views/admin/album_form.php';
    }

    public function update(int $id): void
    {
        $album = Album::find($id);
        if (!$album) {
            header('Location: /admin/albums');
            exit;
        }

        $cover = $album['cover'];
        $newCover = $this->handleUpload($_FILES['cover'] ?? null, 'albums');
        if ($newCover) {
            $cover = $newCover;
        }

        Album::update($id, [
            'artist_id' => (int) $_POST['artist_id'],
            'title' => trim($_POST['title']),
            'release_date' => $_POST['release_date'] ?? null,
            'description' => trim($_POST['description'] ?? ''),
            'cover' => $cover,
            'genre_id' => $_POST['genre_id'] ?? null,
        ]);

        header('Location: /admin/albums');
        exit;
    }

    public function delete(int $id): void
    {
        Album::delete($id);
        header('Location: /admin/albums');
        exit;
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (empty($data['artist_id'])) {
            $errors[] = 'Selecciona un artista.';
        }

        if (trim($data['title'] ?? '') === '') {
            $errors[] = 'El titulo del album es obligatorio.';
        }

        return $errors;
    }

    private function handleUpload(?array $file, string $folder): ?string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file['type'], $allowed, true)) {
            return null;
        }

        $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $filename = uniqid($folder . '_', true) . '.' . $extension;
        $directory = $this->config['app']['upload_dir'] . '/' . $folder;

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $destination = $directory . '/' . $filename;
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            return null;
        }

        return trim($this->config['app']['upload_url'] . '/' . $folder . '/' . $filename, '/');
    }
}
