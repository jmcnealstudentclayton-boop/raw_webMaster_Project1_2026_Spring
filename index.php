<?php require_once 'pageInserts/db_connect.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webMaster Project Spring 2026</title>
    <script src="https://cdn.tailwindcss.com"> </script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="mainBody">
<?php include 'pageInserts/nav.php'; ?>
<main class="flex-1 w-full max-w-6xl mx-auto px-6 py-8">
    <h1 class="text-3xl font-bold mb-4">Welcome to the Movie Database</h1>
    <p class="text-slate-600 text-lg">Discover movies, read reviews, and manage your watchlist all in one place.</p>


<!--Quick links -->
<div class="grid grid-cols-4 gap-5 mb-10">
    <a href="pages/movies/index.php" class="bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-indigo-500 ">
        <h3 class="text-lg font-semibold mb-2">Browse Movies</h3>
        <p class="text-slate-400 text-sm">Search and explore movies</p>
    </a>
    <a href="pages/reviews/index.php" class="bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-indigo-500 ">
        <h3 class="text-lg font-semibold mb-2">Read Reviews</h3>
        <p class="text-slate-400 text-sm">See what others are saying</p>
    </a>
    <a href="pages/watchlist/index.php" class="bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-indigo-500 ">
        <h3 class="text-lg font-semibold mb-2">Manage Watchlist</h3>
        <p class="text-slate-400 text-sm">Keep track of movies you want to watch</p>
    </a>
    <a href="pages/reports/index.php" class="bg-slate-800 border border-slate-700 rounded-lg p-5 hover:border-indigo-500 ">
        <h3 class="text-lg font-semibold mb-2">View Reports</h3>
        <p class="text-slate-400 text-sm">Analyze your movie data</p>
    </a>
</div>

<h2 class="text-2xl font-bold mb-4">Featured Movies</h2>
<div class="grid grid-cols-5 gap-5 mb-10">

<?php
$stmt = $pdo->prepare("SELECT title, director, imdb_rating, poster_url FROM movies ORDER BY imdb_rating DESC LIMIT 5");
$stmt->execute();
$movies = $stmt->fetchAll();
?>

<?php foreach($movies as $row): ?>
    <div class="bg-slate-800 border border-slate-700 rounded-lg p-4">
        <img src="<?php echo htmlspecialchars($row['poster_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?> Poster" class="w-full h-64 object-cover mb-3 rounded">
        <h3 class="text-lg font-semibold mb-1"><?php echo htmlspecialchars($row['title']); ?></h3>
        <p class="text-slate-400 text-sm mb-1">Directed by <?php echo htmlspecialchars($row['director']); ?></p>
        <p class="text-slate-400 text-sm">IMDb Rating: <?php echo htmlspecialchars($row['imdb_rating']); ?></p>
</div>
<?php endforeach; ?>
</div>




</main>
<?php include 'pageInserts/footer.php'; ?>
</body>
</html>