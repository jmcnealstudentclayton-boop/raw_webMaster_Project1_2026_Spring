<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>webMaster Project Spring 2026 - Reports</title>
    <script src="https://cdn.tailwindcss.com"> </script>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body class="mainBody">
    <?php include '../../pageInserts/nav.php'; ?>
    <main class="mainMain">
        
        <h1 class="text-3xl font-bold mb-4">Welcome to the reports section</h1>
        <p class="text-slate-600 text-lg">Manage your reports</p>



        <div class="mt-3 space-y-2">
            <div class="bg-slate-800 p-4 rounded-lg flex items-center justify-between">
                <div>
                    <span class="font-semibold">Justin's Report:</span>
                    <span class="text-slate-400 italic ml-2">"Top-Rated Action Movies"</span>
                </div>
                <a href="<?php echo $basePath; ?>/pages/reports/justin.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">View Report</a>
            </div>
            <div class="bg-slate-800 p-4 rounded-lg flex items-center justify-between">
                <div>
                    <span class="font-semibold">Jayse's Report:</span>
                    <span class="text-slate-400 italic ml-2">"Most Watchlisted Movies"</span>
                </div>
                <a href="<?php echo $basePath; ?>/pages/reports/jayse.php" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg">View Report</a>
            </div>
        </div>
         
    </main>
    <?php include '../../pageInserts/footer.php'; ?>
</body>
</html>