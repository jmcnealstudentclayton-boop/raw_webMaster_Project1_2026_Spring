<?php
// load database connection and validation functions
require_once '../../pageInserts/db_connect.php';
require_once '../../pageInserts/validation.php';

// ---- review form processing (uses POST) ----
// set up empty form data and error arrays
$reviewData = [
    'movie_id'      => '',
    'reviewer_name'  => '',
    'rating'        => '',
    'review_text'   => ''
];
$reviewErrors = [
    'movie_id'      => '',
    'reviewer_name'  => '',
    'rating'        => '',
    'review_text'   => ''
];
$reviewSuccess = '';

// only run if the review form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_review'])) {
    // collect all the form values
    $reviewData = [
        'movie_id'      => trim(isset($_POST['movie_id']) ? $_POST['movie_id'] : ''),
        'reviewer_name'  => trim(isset($_POST['reviewer_name']) ? $_POST['reviewer_name'] : ''),
        'rating'        => trim(isset($_POST['rating']) ? $_POST['rating'] : ''),
        'review_text'   => trim(isset($_POST['review_text']) ? $_POST['review_text'] : '')
    ];

    // validate each field
    $reviewErrors['movie_id'] = validateInt($reviewData['movie_id'], 'Movie ID');
    $reviewErrors['reviewer_name'] = validateRequired($reviewData['reviewer_name'], 'Your name');
    if (!$reviewErrors['reviewer_name']) {
        $reviewErrors['reviewer_name'] = validateLength($reviewData['reviewer_name'], 'Your name', 1, MAX_NAME_LENGTH);
    }
    $reviewErrors['rating'] = validateRating($reviewData['rating']);
    $reviewErrors['review_text'] = validateRequired($reviewData['review_text'], 'Review');
    if (!$reviewErrors['review_text']) {
        $reviewErrors['review_text'] = validateLength($reviewData['review_text'], 'Review', 10, 1000);
    }

    // check if there were any errors
    $has_errors = implode($reviewErrors);
    if (!$has_errors) {
        // no errors so show success and clear the form
        $reviewSuccess = 'Review for movie #' . htmlspecialchars($reviewData['movie_id']) . ' by "' . htmlspecialchars($reviewData['reviewer_name']) . '" submitted successfully!';
        $reviewData = [
            'movie_id' => '', 'reviewer_name' => '', 'rating' => '', 'review_text' => ''
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webMaster Project Spring 2026</title>
    <script src="https://cdn.tailwindcss.com"> </script>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="mainBody">
    <?php include '../../pageInserts/nav.php'; ?>
    <main class="mainMain">
        <h1 class="text-3xl font-bold mb-4">Welcome to the review section</h1>
        <p class="text-slate-600 text-lg">Leave a review</p>

        <!-- review entry form -->

        <?php if ($reviewSuccess): ?>
            <p class="text-green-400 text-sm mt-4 mb-3"><?php echo $reviewSuccess; ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="bg-slate-800 border border-slate-700 rounded-lg p-6 mt-6">
            <div class="mb-4">
                <label for="movie_id" class="block text-sm font-medium mb-1">Movie ID</label>
                <input type="text" id="movie_id" name="movie_id" required
                    value="<?php echo htmlspecialchars($reviewData['movie_id']); ?>"
                    class="w-full px-3 py-2 bg-slate-700 border <?php echo $reviewErrors['movie_id'] ? 'border-red-500' : 'border-slate-600'; ?> rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-slate-500 text-xs mt-1">Enter the numeric ID of the movie</p>
                <?php if ($reviewErrors['movie_id']): ?>
                    <p class="text-red-400 text-xs mt-1"><?php echo $reviewErrors['movie_id']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="reviewer_name" class="block text-sm font-medium mb-1">Your Name</label>
                <input type="text" id="reviewer_name" name="reviewer_name" required
                    value="<?php echo htmlspecialchars($reviewData['reviewer_name']); ?>"
                    class="w-full px-3 py-2 bg-slate-700 border <?php echo $reviewErrors['reviewer_name'] ? 'border-red-500' : 'border-slate-600'; ?> rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <?php if ($reviewErrors['reviewer_name']): ?>
                    <p class="text-red-400 text-xs mt-1"><?php echo $reviewErrors['reviewer_name']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="rating" class="block text-sm font-medium mb-1">Rating</label>
                <input type="number" id="rating" name="rating" min="1" max="5" step="0.1" required
                    value="<?php echo htmlspecialchars($reviewData['rating']); ?>"
                    class="w-full px-3 py-2 bg-slate-700 border <?php echo $reviewErrors['rating'] ? 'border-red-500' : 'border-slate-600'; ?> rounded focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-slate-500 text-xs mt-1">Rating must be between 1.0 and 5.0</p>
                <?php if ($reviewErrors['rating']): ?>
                    <p class="text-red-400 text-xs mt-1"><?php echo $reviewErrors['rating']; ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <label for="review_text" class="block text-sm font-medium mb-1">Review</label>
                <textarea id="review_text" name="review_text" rows="4" required
                    class="w-full px-3 py-2 bg-slate-700 border <?php echo $reviewErrors['review_text'] ? 'border-red-500' : 'border-slate-600'; ?> rounded focus:outline-none focus:ring-2 focus:ring-indigo-500"><?php echo htmlspecialchars($reviewData['review_text']); ?></textarea>
                <p class="text-slate-500 text-xs mt-1">Must be at least 10 characters</p>
                <?php if ($reviewErrors['review_text']): ?>
                    <p class="text-red-400 text-xs mt-1"><?php echo $reviewErrors['review_text']; ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" name="submit_review" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Submit
                Review</button>
        </form>
    

    <!-- Reviews -->

    <h2 class="text-2xl font-bold mb-4">Featured Movies</h2>
    <div class="grid grid-cols-5 gap-5 mb-10">

        <?php
        // get the 20 most recent reviews with movie title and reviewer name
        $stmt = $pdo->prepare(
            "SELECT r.rating, r.review_text, r.review_date,
                    m.title, u.first_name, u.last_name
            FROM reviews r
            JOIN movies m ON r.movie_id = m.movie_id
            JOIN users u ON r.user_id = u.user_id
            ORDER BY r.review_date DESC
            LIMIT 20"
        );
        $stmt->execute();
        $reviews = $stmt->fetchAll();
        ?>
        <?php foreach ($reviews as $row): ?>
            <div class="bg-slate-800 border border-slate-700 rounded-lg p-4">
                <h3 class="text-lg font-semibold mb-1"><?php echo htmlspecialchars($row['title']); ?></h3>
                <p class="text-slate-400 text-sm mb-1">Reviewed by
                    <?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?> on
                    <?php echo date("F j, Y", strtotime($row['review_date'])); ?></p>
                <p class="text-slate-400 text-sm mb-1">Rating: <?php echo htmlspecialchars($row['rating']); ?>/5</p>
                <p class="text-slate-400 text-sm"><?php echo htmlspecialchars($row['review_text']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
    
    </main>
    <?php include '../../pageInserts/footer.php'; ?>
</body>
</html>