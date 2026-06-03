<?php

namespace App\Traits;

trait HasImageUrl
{
    public static function resolveImageUrl($path, ?string $defaultDirectory = null)
    {
        if (empty($path)) {
            return null;
        }

        if (is_array($path)) {
            $path = array_values(array_filter($path, function ($item) {
                return is_scalar($item) && trim((string) $item) !== '';
            }));
            $path = $path[0] ?? null;
        }

        if (!is_string($path)) {
            $path = (string) $path;
        }

        $path = trim($path);
        $path = ltrim($path, '/');

        if (preg_match('/^https?:\/\//i', $path)) {
            return $path;
        }

        $candidates = [];

        if (str_starts_with($path, 'storage/') || str_starts_with($path, 'uploads/')) {
            $candidates[] = public_path($path);
        } else {
            $candidates[] = public_path($path);
        }

        if ($defaultDirectory) {
            $defaultDirectory = trim($defaultDirectory, '/');
            $candidates[] = public_path('uploads/' . $defaultDirectory . '/' . $path);
            $candidates[] = public_path('storage/' . $defaultDirectory . '/' . $path);
            $candidates[] = public_path('admin/' . $defaultDirectory . '/' . $path);
        }

        if (!str_starts_with($path, 'storage/') && !str_starts_with($path, 'uploads/')) {
            $candidates[] = public_path('storage/' . $path);
            $candidates[] = public_path('uploads/' . $path);
            $candidates[] = public_path('admin/' . $path);
        }

        foreach ($candidates as $candidate) {
            if (file_exists($candidate)) {
                $relativePath = str_replace(public_path(), '', $candidate);
                $relativePath = str_replace('\\', '/', $relativePath);
                return asset('/' . ltrim($relativePath, '/'));
            }
        }

        if (str_starts_with($path, 'uploads/') || str_starts_with($path, 'storage/')) {
            return asset('/' . ltrim(str_replace('\\', '/', $path), '/'));
        }

        if ($defaultDirectory) {
            return asset('/uploads/' . trim($defaultDirectory, '/') . '/' . ltrim(str_replace('\\', '/', $path), '/'));
        }

        return asset('/' . ltrim(str_replace('\\', '/', $path), '/'));
    }

    private static function makeRelativeUrl(string $path): string
    {
        $url = str_replace('\\', '/', $path);
        return '/' . ltrim($url, '/');
    }
}
