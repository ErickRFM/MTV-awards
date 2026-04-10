<?php

$firstEnv = static function (array $keys, $default = null) {
    foreach ($keys as $key) {
        $value = getenv($key);
        if ($value !== false && $value !== '') {
            return $value;
        }

        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }

        if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
            return $_SERVER[$key];
        }
    }

    return $default;
};

$normalizePath = static function (string $path): string {
    return rtrim(str_replace('\\', '/', $path), '/');
};

$databaseUrl = $firstEnv([
    'DATABASE_URL',
    'MYSQL_PUBLIC_URL',
    'MYSQL_URL',
    'URL_PUBLICA_DE_MYSQL',
    'URL_MYSQL',
    'URL_MYSQL_PUBLICA',
], '');

$parsedUrl = $databaseUrl ? parse_url($databaseUrl) : [];
$hasDatabaseUrl = !empty($parsedUrl['host']);

$dbHost = $hasDatabaseUrl
    ? $parsedUrl['host']
    : $firstEnv([
        'DB_HOST',
        'MYSQLHOST',
        'MYSQL_HOST',
        'HOST_MYSQL',
    ], '127.0.0.1');

$dbPort = $hasDatabaseUrl
    ? (int) ($parsedUrl['port'] ?? 3306)
    : (int) $firstEnv([
        'DB_PORT',
        'MYSQLPORT',
        'MYSQL_PORT',
        'PUERTO_MYSQL',
    ], 3306);

$dbName = $hasDatabaseUrl
    ? ltrim($parsedUrl['path'] ?? '/DataMTVAwards', '/')
    : $firstEnv([
        'DB_NAME',
        'MYSQLDATABASE',
        'MYSQL_DATABASE',
        'BASE_DE_DATOS_MYSQL',
    ], 'DataMTVAwards');

$dbUser = $hasDatabaseUrl
    ? ($parsedUrl['user'] ?? 'root')
    : $firstEnv([
        'DB_USER',
        'MYSQLUSER',
        'MYSQL_USER',
        'USUARIO_DE_MYSQL',
    ], 'root');

$dbPass = $hasDatabaseUrl
    ? ($parsedUrl['pass'] ?? '')
    : $firstEnv([
        'DB_PASS',
        'MYSQLPASSWORD',
        'MYSQL_PASSWORD',
        'CONTRASENA_DE_MYSQL',
        'CONTRASENA_ROOT_MYSQL',
    ], '');

$defaultUploadDir = $normalizePath(realpath(__DIR__ . '/../public/uploads') ?: (__DIR__ . '/../public/uploads'));
$renderDiskFallback = '/var/data/mtv-awards/uploads';
$configuredUploadDir = $firstEnv([
    'UPLOAD_STORAGE_PATH',
    'RENDER_DISK_PATH',
    'PERSISTENT_DISK_PATH',
    'DISK_MOUNT_PATH',
], '');

if ($configuredUploadDir === '' && is_dir('/var/data')) {
    $configuredUploadDir = $renderDiskFallback;
}

$uploadDir = $normalizePath($configuredUploadDir !== '' ? $configuredUploadDir : $defaultUploadDir);
$uploadPublicDir = $normalizePath(realpath(__DIR__ . '/../public/uploads') ?: (__DIR__ . '/../public/uploads'));

return [
    'db' => [
        'host' => $dbHost,
        'port' => $dbPort,
        'name' => $dbName,
        'user' => $dbUser,
        'pass' => $dbPass,
        'charset' => $firstEnv(['DB_CHARSET'], 'utf8mb4'),
        'collation' => $firstEnv(['DB_COLLATION'], 'utf8mb4_unicode_ci'),
        'database_url' => $databaseUrl,
    ],
    'app' => [
        'name' => 'MTV Awards',
        'base_url' => rtrim($firstEnv([
            'BASE_URL',
            'RENDER_EXTERNAL_URL',
        ], 'http://localhost:8000'), '/'),
        'upload_dir' => $uploadDir,
        'upload_public_dir' => $uploadPublicDir,
        'upload_url' => '/uploads',
    ],
];
