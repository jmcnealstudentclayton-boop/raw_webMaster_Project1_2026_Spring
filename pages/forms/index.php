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

    // check if its empty or too short
    if (empty($searchValue)) {
        $searchError = 'Please enter a search term.';
    } else if (strlen($searchValue) < MIN_SEARCH_LENGTH) {
        $searchError = 'Search must be at least ' . MIN_SEARCH_LENGTH . ' characters.';
    }

    // if no errors, sanitize and show success
    if (!$searchError) {
        $searchValue = sanitize($searchValue);
        $searchSuccess = 'Showing results for: "' . $searchValue . '"';
    }
}

// ---- add user form processing (uses POST) ----
// set up empty form data and error arrays
$addData = [
    'first_name'        => '',
    'last_name'         => '',
    'email'             => '',
    'subscription_type' => 'free'
];
$addErrors = [
    'first_name'        => '',
    'last_name'         => '',
    'email'             => '',
    'subscription_type' => ''
];
$addSuccess = '';

// only run if the add user form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_user'])) {
    // collect all the form values
    $addData = [
        'first_name'        => trim(isset($_POST['first_name']) ? $_POST['first_name'] : ''),
        'last_name'         => trim(isset($_POST['last_name']) ? $_POST['last_name'] : ''),
        'email'             => trim(isset($_POST['email']) ? $_POST['email'] : ''),
        'subscription_type' => trim(isset($_POST['subscription_type']) ? $_POST['subscription_type'] : 'free')
    ];

    // validate everything using the shared function
    $addErrors = validateUserData($addData);

    // check if there were any errors
    $has_errors = implode($addErrors);
    if (!$has_errors) {
        // no errors so show success and clear the form
        $addSuccess = 'User "' . formatName($addData['first_name'], $addData['last_name']) . '" added successfully!';
        $addData = [
            'first_name' => '', 'last_name' => '', 'email' => '', 'subscription_type' => 'free'
        ];
    }
}

// ---- update user form processing (uses POST) ----
// set up empty form data and error arrays
$updateData = [
    'user_id'           => '',
    'first_name'        => '',
    'last_name'         => '',
    'email'             => '',
    'subscription_type' => 'free'
];
$updateErrors = [
    'user_id'           => '',
    'first_name'        => '',
    'last_name'         => '',
    'email'             => '',
    'subscription_type' => ''
];
$updateSuccess = '';

// only run if the update user form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_user'])) {
    // collect all the form values
    $updateData = [
        'user_id'           => trim(isset($_POST['user_id']) ? $_POST['user_id'] : ''),
        'first_name'        => trim(isset($_POST['first_name']) ? $_POST['first_name'] : ''),
        'last_name'         => trim(isset($_POST['last_name']) ? $_POST['last_name'] : ''),
        'email'             => trim(isset($_POST['email']) ? $_POST['email'] : ''),
        'subscription_type' => trim(isset($_POST['subscription_type']) ? $_POST['subscription_type'] : 'free')
    ];

    // validate everything, pass true to also check user_id
    $updateErrors = validateUserData($updateData, true);

    // check if there were any errors
    $has_errors = implode($updateErrors);
    if (!$has_errors) {
        // no errors so show success and clear the form
        $updateSuccess = 'User "' . formatName($updateData['first_name'], $updateData['last_name']) . '" updated successfully!';
        $updateData = [
            'user_id' => '', 'first_name' => '', 'last_name' => '', 'email' => '', 'subscription_type' => 'free'
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webMaster Project Spring 2026 - Forms</title>
    <script src="https://cdn.tailwindcss.com"> </script>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body class="mainBody">
    <?php include '../../pageInserts/nav.php'; ?>
    <main class="mainMain">

        <h1 class="text-3xl font-bold mb-4">Welcome to the forms section</h1>
        <p class="text-slate-600 text-lg">Manage your forms</p>
        <p class="text-slate-600 text-lg">Coming Soon</p>


        <!-- forms management interface -->
        <div class="mt-6 bg-slate-800 p-5 rounded-xl">

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
        </div>






        <div class="grid grid-cols-2 gap-5 mb-10">
            <div class="mt-6 bg-slate-800 p-5 rounded-xl">

                <!-- Insert Form -->
                <label class="block text-sm text-slate-300 mt-4 mb-1">Add User</label>

                <?php if ($addSuccess): ?>
                    <p class="text-green-400 text-sm mb-3"><?php echo $addSuccess; ?></p>
                <?php endif; ?>

                <form method="POST" action="" class="space-y-3">
                    <div>
                        <label for="edit-first" class="block text-sm text-slate-400 mb-1">First Name</label>
                        <input type="text" name="first_name" id="edit-first" placeholder="First name" required
                            value="<?php echo htmlspecialchars($addData['first_name']); ?>"
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $addErrors['first_name'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                        <?php if ($addErrors['first_name']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $addErrors['first_name']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="edit-last" class="block text-sm text-slate-400 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="edit-last" placeholder="Last name" required
                            value="<?php echo htmlspecialchars($addData['last_name']); ?>"
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $addErrors['last_name'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                        <?php if ($addErrors['last_name']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $addErrors['last_name']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="edit-email" class="block text-sm text-slate-400 mb-1">Email</label>
                        <input type="email" name="email" id="edit-email" placeholder="Email" required
                            value="<?php echo htmlspecialchars($addData['email']); ?>"
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $addErrors['email'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                        <?php if ($addErrors['email']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $addErrors['email']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="edit-sub" class="block text-sm text-slate-400 mb-1">Subscription Type</label>
                        <select name="subscription_type" id="edit-sub" required
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $addErrors['subscription_type'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 focus:outline-none focus:border-indigo-500">
                            <option value="free" <?php echo $addData['subscription_type'] === 'free' ? 'selected' : ''; ?>>Free</option>
                            <option value="basic" <?php echo $addData['subscription_type'] === 'basic' ? 'selected' : ''; ?>>Basic</option>
                            <option value="premium" <?php echo $addData['subscription_type'] === 'premium' ? 'selected' : ''; ?>>Premium</option>
                        </select>
                        <?php if ($addErrors['subscription_type']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $addErrors['subscription_type']; ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="add_user"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg">
                        Add User
                    </button>
                </form>
            </div>

            <div class="mt-6 bg-slate-800 p-5 rounded-xl">

                <!-- Update User Form -->
                <label class="block text-sm text-slate-300 mt-4 mb-1">Update User</label>

                <?php if ($updateSuccess): ?>
                    <p class="text-green-400 text-sm mb-3"><?php echo $updateSuccess; ?></p>
                <?php endif; ?>

                <form method="POST" action="" class="space-y-3">
                    <div>
                        <label for="update-user-id" class="block text-sm text-slate-400 mb-1">User ID</label>
                        <input type="number" name="user_id" id="update-user-id" placeholder="User ID" required
                            value="<?php echo htmlspecialchars($updateData['user_id']); ?>"
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $updateErrors['user_id'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                        <?php if ($updateErrors['user_id']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $updateErrors['user_id']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="update-first" class="block text-sm text-slate-400 mb-1">First Name</label>
                        <input type="text" name="first_name" id="update-first" placeholder="First name" required
                            value="<?php echo htmlspecialchars($updateData['first_name']); ?>"
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $updateErrors['first_name'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                        <?php if ($updateErrors['first_name']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $updateErrors['first_name']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="update-last" class="block text-sm text-slate-400 mb-1">Last Name</label>
                        <input type="text" name="last_name" id="update-last" placeholder="Last name" required
                            value="<?php echo htmlspecialchars($updateData['last_name']); ?>"
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $updateErrors['last_name'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                        <?php if ($updateErrors['last_name']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $updateErrors['last_name']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="update-email" class="block text-sm text-slate-400 mb-1">Email</label>
                        <input type="email" name="email" id="update-email" placeholder="Email" required
                            value="<?php echo htmlspecialchars($updateData['email']); ?>"
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $updateErrors['email'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 placeholder-slate-400 focus:outline-none focus:border-indigo-500">
                        <?php if ($updateErrors['email']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $updateErrors['email']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="update-sub" class="block text-sm text-slate-400 mb-1">Subscription Type</label>
                        <select name="subscription_type" id="update-sub" required
                            class="w-full px-3 py-2 rounded-lg bg-slate-700 border <?php echo $updateErrors['subscription_type'] ? 'border-red-500' : 'border-slate-600'; ?> text-slate-200 focus:outline-none focus:border-indigo-500">
                            <option value="free" <?php echo $updateData['subscription_type'] === 'free' ? 'selected' : ''; ?>>Free</option>
                            <option value="basic" <?php echo $updateData['subscription_type'] === 'basic' ? 'selected' : ''; ?>>Basic</option>
                            <option value="premium" <?php echo $updateData['subscription_type'] === 'premium' ? 'selected' : ''; ?>>Premium</option>
                        </select>
                        <?php if ($updateErrors['subscription_type']): ?>
                            <p class="text-red-400 text-xs mt-1"><?php echo $updateErrors['subscription_type']; ?></p>
                        <?php endif; ?>
                    </div>

                    <button type="submit" name="update_user"
                        class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg">
                        Update User
                    </button>
                </form>
            </div>

        </div>
    </main>
    <?php include '../../pageInserts/footer.php'; ?>
</body>

</html>