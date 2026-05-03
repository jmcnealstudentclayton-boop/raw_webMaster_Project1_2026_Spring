<?php
// load database connection and validation functions
require_once '../../pageInserts/db_connect.php';
require_once '../../pageInserts/validation.php';

// ---- search form processing (uses GET) ----
$searchError = '';
$searchSuccess = '';
$searchValue = '';

if (isset($_GET['search'])) {
    // grab the search input
    $searchValue = trim($_GET['search']);

    // check if empty
    if (empty($searchValue)) {
        $searchError = 'Please enter a search term.';
    }
    // check if too short
    else if (strlen($searchValue) < 2) {
        $searchError = 'Search must be at least 2 characters.';
    }
    // if valid, sanitize and show success
    else {
        $searchValue = sanitize($searchValue);
        $searchSuccess = 'Showing results for: "' . $searchValue . '"';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webMaster Project Spring 2026 - Movies</title>
    <script src="https://cdn.tailwindcss.com"> </script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="mainBody">
    <?php include '../../pageInserts/nav.php'; ?>
    <main class="mainMain">
        
        <h1 class="text-3xl font-bold mb-4">Welcome to the movies section</h1>
        <p class="text-slate-600 text-lg">Manage your movies</p>

         <!-- Search Form -->
        <form method="GET" action="" class="mt-6 mb-4 flex gap-3">
            <input type="text" name="search" placeholder="Search movies by title..."
                   value="<?php echo htmlspecialchars($searchValue); ?>"
                   class="flex-1 px-4 py-2 rounded-lg bg-slate-700 border <?php echo $searchError ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
            <button type="submit"
                    class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg">
                Search
            </button>
        </form>

        <?php if ($searchError): ?>
            <p class="text-red-400 text-sm mb-4"><?php echo $searchError; ?></p>
        <?php endif; ?>

        <?php if ($searchSuccess): ?>
            <p class="text-green-400 text-sm mb-4"><?php echo $searchSuccess; ?></p>
        <?php endif; ?>

        <!-- movies management interface -->

        <?php if ($searchSuccess): ?>
            <div class="grid grid-cols-5 gap-5 mb-10">
            <?php
            // search the database for movies matching the search term
            $search_param = '%' . $searchValue . '%';
            $stmt = $pdo->prepare("SELECT * FROM movies WHERE title LIKE :search ORDER BY imdb_rating DESC");
            $stmt->execute(['search' => $search_param]);
            $movies = $stmt->fetchAll();
            ?>

            <?php if (count($movies) > 0): ?>
                <?php foreach($movies as $row): ?>
                    <div class="bg-slate-800 border border-slate-700 rounded-lg p-4">
                        <img src="<?php echo htmlspecialchars($row['poster_url']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?> Poster" class="w-full h-64 object-cover mb-3 rounded">
                        <h3 class="text-lg font-semibold mb-1"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p class="text-slate-400 text-sm mb-1">Directed by <?php echo htmlspecialchars($row['director']); ?></p>
                        <p class="text-slate-400 text-sm">IMDb Rating: <?php echo htmlspecialchars($row['imdb_rating']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-slate-400 text-sm col-span-5">No movies found matching your search.</p>
            <?php endif; ?>
            </div>
        <?php endif; ?>
         
    </main>
    <?php include '../../pageInserts/footer.php'; ?>
</body>
</html>