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
<nav class="bg-slate-800 border-b border-slate-700 sticky top-0 z-50 px-6 py-3">
    <div class="flex justify-between items-center mx-auto max-w-6xl flex-wrap gap-3">
        <a href="<?php echo $basePath; ?>/index.php" class="flex items-center gap-2 no-underline group">
            <img src="<?php echo $basePath; ?>/assets/logo/logo.png" alt="Movie Database Logo" class="h-10 transition-transform duration-200 group-hover:scale-110">
        </a>
        <ul class="flex-wrap list-none gap-6 w-auto flex">
            <li><a href="<?php echo $basePath; ?>/index.php" class="text-slate-400 hover:text-slate-200 text-sm no-underline">Home</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/movies/index.php" class="text-slate-400 hover:text-slate-200 text-sm no-underline">Movies</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/reviews/index.php" class="text-slate-400 hover:text-slate-200 text-sm no-underline">Reviews</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/watchlist/index.php" class="text-slate-400 hover:text-slate-200 text-sm no-underline">Watchlist</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/reports/index.php" class="text-slate-400 hover:text-slate-200 text-sm no-underline">Reports</a></li>
            <li><a href="<?php echo $basePath; ?>/pages/forms/index.php" class="text-slate-400 hover:text-slate-200 text-sm no-underline">Forms</a></li>
        </ul>
    </div>
</nav>