<?php

require_once __DIR__ . '/../Models/User.php';

class AuthController
{
    public function showLogin(?string $error = null, array $old = []): void
    {
        require __DIR__ . '/../Views/admin/login.php';
    }

    public function showRegister(array $errors = [], array $old = []): void
    {
        require __DIR__ . '/../Views/public/register.php';
    }

    public function login(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        $user = User::findByEmail($email);

        if ($user && $this->passwordMatches($password, $user['password'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = $user;

            if ((int) $user['role_id'] === 1 || (int) $user['role_id'] === 2) {
                header('Location: /admin/dashboard');
                exit;
            }

            header('Location: /');
            exit;
        }

        $this->showLogin('Credenciales invalidas.', [
            'email' => $email,
        ]);
    }

    public function register(): void
    {
        $data = [
            'username' => trim($_POST['username'] ?? ''),
            'display_name' => trim($_POST['display_name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirmation' => $_POST['password_confirmation'] ?? '',
        ];

        $errors = [];

        if ($data['username'] === '') {
            $errors[] = 'El usuario es obligatorio.';
        }

        if (User::findByUsername($data['username'])) {
            $errors[] = 'Ese nombre de usuario ya existe.';
        }

        if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Ingresa un correo valido.';
        }

        if ($data['password'] === '' || strlen($data['password']) < 8) {
            $errors[] = 'La contrasena debe tener al menos 8 caracteres.';
        }

        if ($data['password'] !== $data['password_confirmation']) {
            $errors[] = 'Las contrasenas no coinciden.';
        }

        if (User::findByEmail($data['email'])) {
            $errors[] = 'Ese correo ya esta registrado.';
        }

        if ($errors !== []) {
            $this->showRegister($errors, $data);
            return;
        }

        $userId = User::create([
            'username' => $data['username'],
            'display_name' => $data['display_name'] ?: $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => 3,
            'status' => 1,
        ]);

        $_SESSION['user'] = User::findById($userId);

        header('Location: /');
        exit;
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();
        header('Location: /login');
        exit;
    }

    private function passwordMatches(string $plainPassword, string $storedPassword): bool
    {
        if (password_verify($plainPassword, $storedPassword)) {
            return true;
        }

        if (strpos($storedPassword, '*') === 0) {
            return '*' . hash('sha512', $plainPassword) === $storedPassword;
        }

        return false;
    }
}
