<?php
// report_jayse.php — Most Watchlisted Movies
// Author: Jayse
// Query: Movies that have been added to at least 1 watchlist, ranked by how many
//        users have saved them, showing watched vs. unwatched counts
//        JOIN: movies -> watchlist
//        WHERE: watchlist_count >= 1 (HAVING) AND movies with a title (sanity check)
// Uses PDO prepared statements exclusively

require_once '../../pageInserts/db_connect.php';

try {
    $stmt = $pdo->prepare(
        "SELECT m.movie_id,
                m.title,
                m.director,
                m.release_year,
                m.imdb_rating,
                COUNT(w.watchlist_id)                           AS watchlist_count,
                SUM(CASE WHEN w.watched = 1 THEN 1 ELSE 0 END) AS watched_count,
                SUM(CASE WHEN w.watched = 0 THEN 1 ELSE 0 END) AS unwatched_count
         FROM movies m
         JOIN watchlist w ON m.movie_id = w.movie_id
         WHERE m.title IS NOT NULL
         GROUP BY m.movie_id, m.title, m.director, m.release_year, m.imdb_rating
         HAVING COUNT(w.watchlist_id) >= :min_saves
         ORDER BY watchlist_count DESC, m.imdb_rating DESC
         LIMIT 50"
    );
    $stmt->execute([':min_saves' => 1]);
    $movies = $stmt->fetchAll();
} catch (PDOException $e) {
    $movies  = [];
    $dbError = 'Could not load report data. Please try again later.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Watchlisted Movies — Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="mainBody">
<?php include '../../pageInserts/nav.php'; ?>
<main class="mainMain">

    <a href="index.php" class="text-indigo-400 hover:text-indigo-300 text-sm mb-6 inline-block">← Back to Reports</a>

    <h1 class="text-3xl font-bold mb-1">Most Watchlisted Movies</h1>
    <p class="text-slate-400 text-sm mb-1">Report by <span class="text-slate-300">Jayse</span></p>
    <p class="text-slate-400 text-sm mb-6">
        Movies ranked by how many users have added them to their watchlist.
        Includes a breakdown of how many have been watched vs. still pending.
        Showing top <?php echo count($movies); ?> result(s).
    </p>

    <?php if (isset($dbError)): ?>
        <p class="text-red-400"><?php echo $dbError; ?></p>
    <?php elseif (empty($movies)): ?>
        <p class="text-slate-400">No watchlist data found.</p>
    <?php else: ?>

        <!-- Summary stats -->
        <?php
        $totalSaves    = array_sum(array_column($movies, 'watchlist_count'));
        $totalWatched  = array_sum(array_column($movies, 'watched_count'));
        $topMovie      = $movies[0]['title'];
        $watchedPct    = $totalSaves > 0 ? round(($totalWatched / $totalSaves) * 100) : 0;
        ?>
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-indigo-400"><?php echo $totalSaves; ?></p>
                <p class="text-slate-400 text-sm">Total Watchlist Saves</p>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-4 text-center">
                <p class="text-2xl font-bold text-indigo-400"><?php echo $watchedPct; ?>%</p>
                <p class="text-slate-400 text-sm">Already Watched</p>
            </div>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-4 text-center">
                <p class="text-lg font-bold text-indigo-400 truncate"><?php echo htmlspecialchars($topMovie); ?></p>
                <p class="text-slate-400 text-sm">Most Saved Movie</p>
            </div>
        </div>

        <!-- Results table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-slate-400 border-b border-slate-600">
                    <tr>
                        <th class="pb-3 pr-4">Rank</th>
                        <th class="pb-3 pr-4">Title</th>
                        <th class="pb-3 pr-4">Director</th>
                        <th class="pb-3 pr-4">Year</th>
                        <th class="pb-3 pr-4">IMDb</th>
                        <th class="pb-3 pr-4">Saves</th>
                        <th class="pb-3 pr-4">Watched</th>
                        <th class="pb-3">Still Pending</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movies as $i => $row): ?>
                        <tr class="border-b border-slate-700 hover:bg-slate-800">
                            <td class="py-3 pr-4 text-slate-400"><?php echo $i + 1; ?></td>
                            <td class="py-3 pr-4 font-medium"><?php echo htmlspecialchars($row['title']); ?></td>
                            <td class="py-3 pr-4 text-slate-400"><?php echo htmlspecialchars($row['director']); ?></td>
                            <td class="py-3 pr-4 text-slate-400"><?php echo htmlspecialchars($row['release_year']); ?></td>
                            <td class="py-3 pr-4">
                                <span class="text-yellow-400">★ <?php echo htmlspecialchars($row['imdb_rating']); ?></span>
                            </td>
                            <td class="py-3 pr-4">
                                <span class="font-bold text-indigo-300"><?php echo htmlspecialchars($row['watchlist_count']); ?></span>
                            </td>
                            <td class="py-3 pr-4 text-green-400"><?php echo htmlspecialchars($row['watched_count']); ?></td>
                            <td class="py-3 text-slate-400"><?php echo htmlspecialchars($row['unwatched_count']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</main>
<?php include '../../pageInserts/footer.php'; ?>
</body>
</html>
