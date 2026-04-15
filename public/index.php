<?php

session_start();

require_once __DIR__ . '/../app/Support/media.php';
require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/PublicController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';
require_once __DIR__ . '/../app/Controllers/UserController.php';
require_once __DIR__ . '/../app/Controllers/ArtistController.php';
require_once __DIR__ . '/../app/Controllers/AlbumController.php';
require_once __DIR__ . '/../app/Controllers/GenreController.php';
require_once __DIR__ . '/../app/Controllers/SongController.php';
require_once __DIR__ . '/../app/Controllers/NominationController.php';
require_once __DIR__ . '/../app/Controllers/VoteController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

function redirectTo(string $path): void
{
    header('Location: ' . $path);
    exit;
}

function guardAdmin(): void
{
    if (empty($_SESSION['user'])) {
        redirectTo('/login');
    }

    $roleId = (int) ($_SESSION['user']['role_id'] ?? 0);
    if (!in_array($roleId, [1, 2], true)) {
        redirectTo('/');
    }
}

function guardRoles(array $allowedRoles): void
{
    guardAdmin();

    $roleId = (int) ($_SESSION['user']['role_id'] ?? 0);
    if (!in_array($roleId, $allowedRoles, true)) {
        redirectTo('/admin/dashboard');
    }
}

if ($uri === '/' || $uri === '/home') {
    (new PublicController())->home();
    exit;
}

if ($uri === '/nominations') {
    (new PublicController())->nominations();
    exit;
}

if ($uri === '/artists') {
    (new PublicController())->artists();
    exit;
}

if ($uri === '/albums') {
    (new PublicController())->albums();
    exit;
}

if ($uri === '/nomination' && isset($_GET['id'])) {
    (new PublicController())->nomination((int) $_GET['id']);
    exit;
}

if ($uri === '/artist' && isset($_GET['id'])) {
    (new PublicController())->artist((int) $_GET['id']);
    exit;
}

if ($uri === '/album' && isset($_GET['id'])) {
    (new PublicController())->album((int) $_GET['id']);
    exit;
}

if ($uri === '/login' && $method === 'GET') {
    (new AuthController())->showLogin();
    exit;
}

if ($uri === '/login' && $method === 'POST') {
    (new AuthController())->login();
    exit;
}

if ($uri === '/register' && $method === 'GET') {
    (new AuthController())->showRegister();
    exit;
}

if ($uri === '/register' && $method === 'POST') {
    (new AuthController())->register();
    exit;
}

if ($uri === '/logout') {
    (new AuthController())->logout();
    exit;
}

if ($uri === '/api/vote' && $method === 'POST') {
    (new VoteController())->create();
    exit;
}

if (strpos($uri, '/admin') === 0) {
    guardAdmin();
}

if ($uri === '/admin/dashboard') {
    (new AdminController())->dashboard();
    exit;
}

if ($uri === '/admin/users') {
    guardRoles([1]);
    (new UserController())->list();
    exit;
}

if ($uri === '/admin/user/create') {
    guardRoles([1]);
    (new UserController())->createForm();
    exit;
}

if ($uri === '/admin/user/store' && $method === 'POST') {
    guardRoles([1]);
    (new UserController())->store();
    exit;
}

if ($uri === '/admin/user/edit' && isset($_GET['id'])) {
    guardRoles([1]);
    (new UserController())->editForm((int) $_GET['id']);
    exit;
}

if ($uri === '/admin/user/update' && $method === 'POST') {
    guardRoles([1]);
    (new UserController())->update((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/user/delete' && $method === 'POST') {
    guardRoles([1]);
    (new UserController())->delete((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/artists') {
    (new ArtistController())->list();
    exit;
}

if ($uri === '/admin/artist/create') {
    (new ArtistController())->createForm();
    exit;
}

if ($uri === '/admin/artist/store' && $method === 'POST') {
    (new ArtistController())->store();
    exit;
}

if ($uri === '/admin/artist/edit' && isset($_GET['id'])) {
    (new ArtistController())->editForm((int) $_GET['id']);
    exit;
}

if ($uri === '/admin/artist/update' && $method === 'POST') {
    (new ArtistController())->update((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/artist/delete' && $method === 'POST') {
    (new ArtistController())->delete((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/albums') {
    (new AlbumController())->list();
    exit;
}

if ($uri === '/admin/genres') {
    (new GenreController())->list();
    exit;
}

if ($uri === '/admin/album/create') {
    (new AlbumController())->createForm();
    exit;
}

if ($uri === '/admin/genre/create') {
    (new GenreController())->createForm();
    exit;
}

if ($uri === '/admin/album/store' && $method === 'POST') {
    (new AlbumController())->store();
    exit;
}

if ($uri === '/admin/genre/store' && $method === 'POST') {
    (new GenreController())->store();
    exit;
}

if ($uri === '/admin/album/edit' && isset($_GET['id'])) {
    (new AlbumController())->editForm((int) $_GET['id']);
    exit;
}

if ($uri === '/admin/genre/edit' && isset($_GET['id'])) {
    (new GenreController())->editForm((int) $_GET['id']);
    exit;
}

if ($uri === '/admin/album/update' && $method === 'POST') {
    (new AlbumController())->update((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/genre/update' && $method === 'POST') {
    (new GenreController())->update((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/album/delete' && $method === 'POST') {
    (new AlbumController())->delete((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/genre/delete' && $method === 'POST') {
    (new GenreController())->delete((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/songs') {
    (new SongController())->list();
    exit;
}

if ($uri === '/admin/songs/create') {
    (new SongController())->createForm();
    exit;
}

if ($uri === '/admin/songs/store' && $method === 'POST') {
    (new SongController())->create();
    exit;
}

if ($uri === '/admin/songs/edit' && isset($_GET['id'])) {
    (new SongController())->editForm((int) $_GET['id']);
    exit;
}

if ($uri === '/admin/songs/update' && $method === 'POST') {
    (new SongController())->update((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/songs/delete' && $method === 'POST') {
    (new SongController())->delete((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/nominations') {
    guardRoles([1]);
    (new NominationController())->list();
    exit;
}

if ($uri === '/admin/nomination/create') {
    guardRoles([1]);
    (new NominationController())->createForm();
    exit;
}

if ($uri === '/admin/nomination/store' && $method === 'POST') {
    guardRoles([1]);
    (new NominationController())->store();
    exit;
}

if ($uri === '/admin/nomination/edit' && isset($_GET['id'])) {
    guardRoles([1]);
    (new NominationController())->editForm((int) $_GET['id']);
    exit;
}

if ($uri === '/admin/nomination/update' && $method === 'POST') {
    guardRoles([1]);
    (new NominationController())->update((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/nomination/delete' && $method === 'POST') {
    guardRoles([1]);
    (new NominationController())->delete((int) ($_POST['id'] ?? 0));
    exit;
}

if ($uri === '/admin/nomination-add-item' && $method === 'POST') {
    guardRoles([1]);
    (new NominationController())->addItem();
    exit;
}

if ($uri === '/admin/nomination-item/delete' && $method === 'POST') {
    guardRoles([1]);
    (new NominationController())->deleteItem((int) ($_POST['id'] ?? 0));
    exit;
}

http_response_code(404);
echo '404 Not Found';
