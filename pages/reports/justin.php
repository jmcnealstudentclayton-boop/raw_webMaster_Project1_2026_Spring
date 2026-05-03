<?php
// Justin McNeal
# hi teach :)
// Shows all Action genre movies ranked by IMDb rating, with genre confirmed via join
// adds the db connection
require_once '../../pageInserts/db_connect.php';


try {
    //prepares the sql statement
    $stmt = $pdo->prepare(
        "SELECT m.title, m.director, m.release_year, m.runtime, m.rated, m.imdb_rating, m.poster_url
         FROM movies m
         JOIN movie_genres mg ON m.movie_id = mg.movie_id
         JOIN genres g ON mg.genre_id = g.genre_id
         WHERE g.genre_name = :genre
         ORDER BY m.imdb_rating DESC"
    );
    //executes the statement using action as the genre
    $stmt->execute([':genre' => 'Action']);
    //fetches all results
    $movies = $stmt->fetchAll();
} catch (PDOException $e) {
    //if nothing loads then results error saying unable to load
    $movies = [];
    $error = 'Unable to load report. Please try again later.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webMaster Project Spring 2026 - Top-Rated Action Movies</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="mainBody">
    <?php include '../../pageInserts/nav.php'; ?>
    <main class="mainMain">

        <div class="mb-6">
            <a href="index.php" class="text-indigo-400 hover:text-indigo-300 text-sm">&larr; Back to Reports</a>
        </div>

        <h1 class="text-3xl font-bold mb-1">Top-Rated Action Movies</h1>
        <p class="text-slate-400 text-sm mb-6">Report by Justin McNeal Ranked by IMDb rating</p>
        
        
        <!-- if error then show the error -->
        <?php if (isset($error)): ?>
            <p class="text-red-400"><?php echo $error; ?></p>
        <!-- if empty then say that its empty -->
        <?php elseif (empty($movies)): ?>
            <p class="text-slate-400">No action movies found in the database.</p>
        <!-- otherwise show the movie -->
        <?php else: ?>
            <p class="text-slate-400 text-sm mb-4"><?php echo count($movies); ?> movies found</p>
            <div class="grid grid-cols-5 gap-5">
                <!-- for each loop which loops through the movies and shows them -->
                <?php foreach ($movies as $i => $row): ?>
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-4 relative">
                        <span class="absolute top-3 right-3 bg-indigo-600 text-white text-xs font-bold px-2 py-1 rounded">
                            <!-- shows the number -->
                            #<?php echo $i + 1; ?>
                        </span>
                        <!-- html special characters to show the poster, title, etc. -->
                        <img src="<?php echo htmlspecialchars($row['poster_url']); ?>"
                             alt="<?php echo htmlspecialchars($row['title']); ?> Poster"
                             class="w-full h-64 object-cover mb-3 rounded">
                        <h3 class="text-lg font-semibold mb-1 pr-8"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="text-slate-400 text-sm mb-1">Directed by <?php echo htmlspecialchars($row['director']); ?></p>
                        <p class="text-slate-400 text-sm mb-1"><?php echo htmlspecialchars($row['release_year']); ?> &bull; <?php echo htmlspecialchars($row['runtime']); ?> min &bull; <?php echo htmlspecialchars($row['rated']); ?></p>
                        <p class="text-yellow-400 text-sm font-semibold">&#9733; <?php echo htmlspecialchars($row['imdb_rating']); ?> / 10</p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </main>
    <?php include '../../pageInserts/footer.php'; ?>
</body>
</html>
