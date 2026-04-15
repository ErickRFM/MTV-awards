<?php

require_once __DIR__ . '/../Models/Genre.php';

class GenreController
{
    public function list(): void
    {
        $genres = Genre::all();
        require __DIR__ . '/../Views/admin/genres_list.php';
    }

    public function createForm(array $errors = [], array $old = []): void
    {
        $genre = $old;
        require __DIR__ . '/../Views/admin/genre_form.php';
    }

    public function store(): void
    {
        $errors = $this->validate($_POST);
        if ($errors !== []) {
            $this->createForm($errors, $_POST);
            return;
        }

        Genre::create([
            'name' => trim($_POST['name']),
        ]);

        header('Location: /admin/genres');
        exit;
    }

    public function editForm(int $id, array $errors = []): void
    {
        $genre = Genre::find($id);
        if (!$genre) {
            header('Location: /admin/genres');
            exit;
        }

        require __DIR__ . '/../Views/admin/genre_form.php';
    }

    public function update(int $id): void
    {
        $genre = Genre::find($id);
        if (!$genre) {
            header('Location: /admin/genres');
            exit;
        }

        $errors = $this->validate($_POST, $id);
        if ($errors !== []) {
            $genre = array_merge($genre, $_POST, ['id' => $id]);
            require __DIR__ . '/../Views/admin/genre_form.php';
            return;
        }

        Genre::update($id, [
            'name' => trim($_POST['name']),
        ]);

        header('Location: /admin/genres');
        exit;
    }

    public function delete(int $id): void
    {
        Genre::delete($id);
        header('Location: /admin/genres');
        exit;
    }

    private function validate(array $data, int $ignoreId = 0): array
    {
        $errors = [];
        $name = trim($data['name'] ?? '');

        if ($name === '') {
            $errors[] = 'El nombre del genero es obligatorio.';
        }

        if ($name !== '' && Genre::findByName($name, $ignoreId > 0 ? $ignoreId : null)) {
            $errors[] = 'Ese genero ya existe.';
        }

        return $errors;
    }
}
