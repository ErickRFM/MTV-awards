<?php

require_once __DIR__ . '/../Models/User.php';

class UserController
{
    protected array $config;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/config.php';
    }

    public function list(): void
    {
        $users = User::all();
        require __DIR__ . '/../Views/admin/users_list.php';
    }

    public function createForm(array $errors = [], array $old = []): void
    {
        $user = $old;
        $roles = User::roles();
        require __DIR__ . '/../Views/admin/user_form.php';
    }

    public function store(): void
    {
        $errors = $this->validate($_POST);
        if ($errors !== []) {
            $this->createForm($errors, $_POST);
            return;
        }

        $avatar = $this->handleUpload($_FILES['avatar'] ?? null, 'users');

        User::create([
            'username' => trim($_POST['username']),
            'display_name' => trim($_POST['display_name'] ?? ''),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'],
            'role_id' => (int) ($_POST['role_id'] ?? 3),
            'status' => (int) ($_POST['status'] ?? 1),
            'avatar' => $avatar,
        ]);

        header('Location: /admin/users');
        exit;
    }

    public function editForm(int $id, array $errors = []): void
    {
        $user = User::findById($id);
        $roles = User::roles();

        if (!$user) {
            header('Location: /admin/users');
            exit;
        }

        require __DIR__ . '/../Views/admin/user_form.php';
    }

    public function update(int $id): void
    {
        $user = User::findById($id);
        if (!$user) {
            header('Location: /admin/users');
            exit;
        }

        $errors = $this->validate($_POST, true);
        if ($errors !== []) {
            $user = array_merge($user, $_POST);
            $roles = User::roles();
            require __DIR__ . '/../Views/admin/user_form.php';
            return;
        }

        $avatar = $user['avatar'];
        $newAvatar = $this->handleUpload($_FILES['avatar'] ?? null, 'users');
        if ($newAvatar) {
            $avatar = $newAvatar;
        }

        User::update($id, [
            'username' => trim($_POST['username']),
            'display_name' => trim($_POST['display_name'] ?? ''),
            'email' => trim($_POST['email']),
            'password' => $_POST['password'] ?? '',
            'role_id' => (int) ($_POST['role_id'] ?? 3),
            'status' => (int) ($_POST['status'] ?? 1),
            'avatar' => $avatar,
        ]);

        header('Location: /admin/users');
        exit;
    }

    public function delete(int $id): void
    {
        if (!empty($_SESSION['user']) && (int) $_SESSION['user']['id'] === $id) {
            header('Location: /admin/users');
            exit;
        }

        User::delete($id);
        header('Location: /admin/users');
        exit;
    }

    private function validate(array $data, bool $editing = false): array
    {
        $errors = [];
        $currentId = (int) ($data['id'] ?? 0);
        $currentUser = $editing && $currentId > 0 ? User::findById($currentId) : null;
        $existingByUsername = !empty($data['username']) ? User::findByUsername(trim($data['username'])) : null;
        $existingByEmail = !empty($data['email']) ? User::findByEmail(trim($data['email'])) : null;

        if (trim($data['username'] ?? '') === '') {
            $errors[] = 'El usuario es obligatorio.';
        }
        if ($existingByUsername && (!$editing || (int) $existingByUsername['id'] !== (int) ($currentUser['id'] ?? 0))) {
            $errors[] = 'Ese nombre de usuario ya existe.';
        }

        $email = trim($data['email'] ?? '');
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'El correo es obligatorio y debe ser valido.';
        }
        if ($existingByEmail && (!$editing || (int) $existingByEmail['id'] !== (int) ($currentUser['id'] ?? 0))) {
            $errors[] = 'Ese correo ya esta registrado.';
        }

        $password = $data['password'] ?? '';
        if (!$editing && strlen($password) < 8) {
            $errors[] = 'La contrasena debe tener al menos 8 caracteres.';
        }

        if ($editing && $password !== '' && strlen($password) < 8) {
            $errors[] = 'La contrasena debe tener al menos 8 caracteres.';
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
