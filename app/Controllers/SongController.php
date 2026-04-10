<?php

require_once __DIR__ . '/../Models/Song.php';
require_once __DIR__ . '/../Models/Album.php';
require_once __DIR__ . '/../Models/Genre.php';

class SongController
{
    protected array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
    }

    public function list(): void
    {
        $songModel = new Song();
        $songs = $songModel->all();
        require __DIR__ . '/../Views/admin/songs/list.php';
    }

    public function createForm(array $errors = [], array $old = []): void
    {
        $songData = $old;
        $albums = Album::all();
        $genres = Genre::all();
        require __DIR__ . '/../Views/admin/songs/create.php';
    }

    public function create(): void
    {
        $errors = $this->validate($_POST);
        if ($errors !== []) {
            $this->createForm($errors, $_POST);
            return;
        }

        $songModel = new Song();
        $cover = $this->handleUpload($_FILES['cover'] ?? null, 'songs');
        $songModel->create([
            'album_id' => $_POST['album_id'] ?? null,
            'title' => trim($_POST['title']),
            'cover' => $cover,
            'release_date' => $_POST['release_date'] ?? null,
            'genre_id' => $_POST['genre_id'] ?? null,
            'mp3_url' => trim($_POST['mp3_url'] ?? ''),
            'video_url' => trim($_POST['video_url'] ?? ''),
        ]);

        header('Location: /admin/songs');
        exit;
    }

    public function editForm(int $id, array $errors = []): void
    {
        $songModel = new Song();
        $songData = $songModel->find($id);
        if (!$songData) {
            header('Location: /admin/songs');
            exit;
        }

        $albums = Album::all();
        $genres = Genre::all();
        require __DIR__ . '/../Views/admin/songs/edit.php';
    }

    public function update(int $id): void
    {
        $songModel = new Song();
        $existingSong = $songModel->find($id);
        if (!$existingSong) {
            header('Location: /admin/songs');
            exit;
        }

        $errors = $this->validate($_POST);
        if ($errors !== []) {
            $songData = array_merge(['id' => $id], $_POST);
            $albums = Album::all();
            $genres = Genre::all();
            require __DIR__ . '/../Views/admin/songs/edit.php';
            return;
        }

        $cover = $existingSong['cover'] ?? null;
        $newCover = $this->handleUpload($_FILES['cover'] ?? null, 'songs');
        if ($newCover) {
            $cover = $newCover;
        }

        $songModel->update($id, [
            'album_id' => $_POST['album_id'] ?? null,
            'title' => trim($_POST['title']),
            'cover' => $cover,
            'release_date' => $_POST['release_date'] ?? null,
            'genre_id' => $_POST['genre_id'] ?? null,
            'mp3_url' => trim($_POST['mp3_url'] ?? ''),
            'video_url' => trim($_POST['video_url'] ?? ''),
        ]);

        header('Location: /admin/songs');
        exit;
    }

    public function delete(int $id): void
    {
        $songModel = new Song();
        $songModel->delete($id);
        header('Location: /admin/songs');
        exit;
    }

    private function validate(array $data): array
    {
        $errors = [];

        if (trim($data['title'] ?? '') === '') {
            $errors[] = 'El titulo de la cancion es obligatorio.';
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
