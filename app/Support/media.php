<?php

if (!function_exists('app_config')) {
    function app_config(): array
    {
        static $config;

        if ($config === null) {
            $config = require dirname(__DIR__, 2) . '/config/config.php';
        }

        return $config;
    }
}

if (!function_exists('app_base_url')) {
    function app_base_url(): string
    {
        $config = app_config();

        return rtrim((string) ($config['app']['base_url'] ?? ''), '/');
    }
}

if (!function_exists('app_url')) {
    function app_url(string $path = ''): string
    {
        $path = trim($path);
        if ($path === '') {
            return app_base_url();
        }

        if (preg_match('#^(?:[a-z][a-z0-9+.-]*:)?//#i', $path) === 1 || str_starts_with($path, 'data:')) {
            return $path;
        }

        return app_base_url() . '/' . ltrim($path, '/');
    }
}

if (!function_exists('app_public_path')) {
    function app_public_path(string $path = ''): string
    {
        $basePath = dirname(__DIR__, 2) . '/public';
        if ($path === '') {
            return $basePath;
        }

        return $basePath . '/' . ltrim(str_replace('\\', '/', $path), '/');
    }
}

if (!function_exists('normalize_public_asset_path')) {
    function normalize_public_asset_path(string $path): string
    {
        return ltrim(str_replace('\\', '/', $path), '/');
    }
}

if (!function_exists('media_name_candidates')) {
    function media_name_candidates(?string $value): array
    {
        $value = trim((string) $value);
        if ($value === '') {
            return [];
        }

        if (function_exists('iconv')) {
            $transliterated = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
            if ($transliterated !== false) {
                $value = $transliterated;
            }
        }

        $value = strtolower($value);
        $value = preg_replace('/[^a-z0-9]+/', '_', $value) ?? '';
        $value = trim($value, '_');
        if ($value === '') {
            return [];
        }

        $variants = [$value];
        $collapsed = str_replace('_', '', $value);
        if ($collapsed !== $value) {
            $variants[] = $collapsed;
        }

        return array_values(array_unique($variants));
    }
}

if (!function_exists('media_url')) {
    function media_url(?string $path, string $fallback, array $options = []): string
    {
        $folder = trim((string) ($options['folder'] ?? ''), '/');
        $hint = $options['hint'] ?? null;
        $extra = is_array($options['extra'] ?? null) ? $options['extra'] : [];
        $extensions = ['jpg', 'jpeg', 'png', 'webp'];
        $candidates = [];

        $normalizedPath = trim((string) $path);
        if ($normalizedPath !== '') {
            $normalizedPath = normalize_public_asset_path($normalizedPath);
            $candidates[] = $normalizedPath;

            $basename = basename($normalizedPath);
            if ($folder !== '' && $basename !== '') {
                $candidates[] = 'uploads/' . $folder . '/' . $basename;
                $candidates[] = 'img/' . $folder . '/' . $basename;
            }
            if ($basename !== '') {
                $candidates[] = 'img/' . $basename;
            }
        }

        foreach (media_name_candidates($hint) as $candidateName) {
            foreach ($extensions as $extension) {
                if ($folder !== '') {
                    $candidates[] = 'uploads/' . $folder . '/' . $candidateName . '.' . $extension;
                    $candidates[] = 'img/' . $folder . '/' . $candidateName . '.' . $extension;
                }
                $candidates[] = 'img/' . $candidateName . '.' . $extension;
            }
        }

        foreach ($extra as $candidate) {
            if (!is_string($candidate) || trim($candidate) === '') {
                continue;
            }
            $candidates[] = normalize_public_asset_path($candidate);
        }

        foreach (array_values(array_unique($candidates)) as $candidate) {
            if (is_file(app_public_path($candidate))) {
                return app_url('/' . $candidate);
            }
        }

        return app_url($fallback);
    }
}

if (!function_exists('record_image_url')) {
    function record_image_url(array $record, string $field, string $folder, string $fallback, ?string $hintField = null): string
    {
        $hint = $hintField !== null ? ($record[$hintField] ?? null) : null;

        return media_url($record[$field] ?? null, $fallback, [
            'folder' => $folder,
            'hint' => $hint,
        ]);
    }
}
