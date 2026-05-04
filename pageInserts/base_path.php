<?php
// Determine the base path relative to the current script
$baseDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
// Walk up to the rawProject root
if (str_contains($baseDir, '/pages/')) {
    $basePath = dirname(dirname($baseDir));
} elseif (str_contains($baseDir, '/pageInserts')) {
    $basePath = dirname($baseDir);
} else {
    $basePath = $baseDir;
}
$basePath = rtrim($basePath, '/');
?>
