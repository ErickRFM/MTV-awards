<?php

require_once __DIR__ . '/../Models/Artist.php';

class ArtistController
{
    protected array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
    }

    public function list(): void
    {
        $artists = Artist::all();
        require __DIR__ . '/../Views/admin/artists_list.php';
    }

    public function createForm(array $errors = [], array $old = []): void
    {
        $artist = $old;
        require __DIR__ . '/../Views/admin/artist_form.php';
    }

    public function store(): void
    {
        $name = trim($_POST['name'] ?? '');
        if ($name === '') {
            $this->createForm(['El nombre del artista es obligatorio.'], $_POST);
            return;
        }

        $photo = $this->handleUpload($_FILES['photo'] ?? null, 'artists');

        Artist::create([
            'name' => $name,
            'pseudonym' => trim($_POST['pseudonym'] ?? ''),
            'sex' => trim($_POST['sex'] ?? ''),
            'nationality' => trim($_POST['nationality'] ?? ''),
            'biography' => trim($_POST['biography'] ?? ''),
            'photo' => $photo,
            'status' => (int) ($_POST['status'] ?? 1),
        ]);

        header('Location: /admin/artists');
        exit;
    }

    public function editForm(int $id, array $errors = []): void
    {
        $artist = Artist::find($id);
        if (!$artist) {
            header('Location: /admin/artists');
            exit;
        }

        require __DIR__ . '/../Views/admin/artist_form.php';
    }

    public function update(int $id): void
    {
        $artist = Artist::find($id);
        if (!$artist) {
            header('Location: /admin/artists');
            exit;
        }

        $photo = $artist['photo'];
        $newPhoto = $this->handleUpload($_FILES['photo'] ?? null, 'artists');
        if ($newPhoto) {
            $photo = $newPhoto;
        }

        Artist::update($id, [
            'name' => trim($_POST['name'] ?? ''),
            'pseudonym' => trim($_POST['pseudonym'] ?? ''),
            'sex' => trim($_POST['sex'] ?? ''),
            'nationality' => trim($_POST['nationality'] ?? ''),
            'biography' => trim($_POST['biography'] ?? ''),
            'photo' => $photo,
            'status' => (int) ($_POST['status'] ?? 1),
        ]);

        header('Location: /admin/artists');
        exit;
    }

    public function delete(int $id): void
    {
        Artist::delete($id);
        header('Location: /admin/artists');
        exit;
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
