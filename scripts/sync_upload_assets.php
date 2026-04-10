<?php

$root = dirname(__DIR__);
$config = require $root . '/config/config.php';
$uploadDir = normalize_path((string) ($config['app']['upload_dir'] ?? ($root . '/public/uploads')));
$publicUploadDir = normalize_path($root . '/public/uploads');
$folders = ['artists', 'albums', 'songs', 'users'];

ensure_directory($uploadDir);
foreach ($folders as $folder) {
    ensure_directory($uploadDir . '/' . $folder);
}

foreach ($folders as $folder) {
    mirrorDirectory($root . '/public/img/' . $folder, $uploadDir . '/' . $folder);
}

if (!paths_share_target($publicUploadDir, $uploadDir)) {
    foreach ($folders as $folder) {
        mirrorDirectory($publicUploadDir . '/' . $folder, $uploadDir . '/' . $folder);
    }

    ensure_public_upload_link($publicUploadDir, $uploadDir);
}

function mirrorDirectory(string $source, string $destination): void
{
    if (!is_dir($source)) {
        return;
    }

    ensure_directory($destination);

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $item) {
        $relativePath = $iterator->getSubPathName();
        $targetPath = $destination . '/' . str_replace('\\', '/', $relativePath);

        if ($item->isDir()) {
            ensure_directory($targetPath);
            continue;
        }

        $targetDirectory = dirname($targetPath);
        ensure_directory($targetDirectory);

        if (!is_file($targetPath)) {
            copy($item->getPathname(), $targetPath);
        }
    }
}

function ensure_public_upload_link(string $publicUploadDir, string $uploadDir): void
{
    if (paths_share_target($publicUploadDir, $uploadDir)) {
        return;
    }

    if (is_link($publicUploadDir) || is_file($publicUploadDir)) {
        unlink($publicUploadDir);
    } elseif (is_dir($publicUploadDir)) {
        delete_directory($publicUploadDir);
    }

    $parent = dirname($publicUploadDir);
    ensure_directory($parent);

    if (!symlink($uploadDir, $publicUploadDir) && !paths_share_target($publicUploadDir, $uploadDir)) {
        throw new RuntimeException('No fue posible enlazar public/uploads al almacenamiento persistente.');
    }
}

function delete_directory(string $path): void
{
    if (!is_dir($path) || is_link($path)) {
        return;
    }

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($iterator as $item) {
        if ($item->isDir() && !$item->isLink()) {
            rmdir($item->getPathname());
            continue;
        }

        unlink($item->getPathname());
    }

    rmdir($path);
}

function ensure_directory(string $path): void
{
    if (is_dir($path)) {
        return;
    }

    mkdir($path, 0775, true);
}

function paths_share_target(string $first, string $second): bool
{
    $firstReal = realpath($first);
    $secondReal = realpath($second);

    if ($firstReal !== false && $secondReal !== false) {
        return normalize_path($firstReal) === normalize_path($secondReal);
    }

    return normalize_path($first) === normalize_path($second);
}

function normalize_path(string $path): string
{
    return rtrim(str_replace('\\', '/', $path), '/');
}
