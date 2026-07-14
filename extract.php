<?php

$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('app/Http/Controllers'));
$perms = [];
foreach ($files as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        preg_match_all('/hasPermission\(\\\'([a-zA-Z0-9\-]+)\\\'/', $content, $matches);
        if (!empty($matches[1])) {
            $perms = array_merge($perms, $matches[1]);
        }
    }
}
$perms = array_unique($perms);
sort($perms);
echo json_encode($perms, JSON_PRETTY_PRINT);
