<?php
require_once __DIR__ . '/../../../Models/Song.php';

if (!isset($_GET['id'])) {
    header('Location: /admin/songs');
    exit;
}

$song = new Song();
$song->delete($_GET['id']);

header('Location: /admin/songs');
exit;
