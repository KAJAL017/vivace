<?php
// Load Laravel bootstrap to get config
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$appUrl    = config('app.url');
$appEnv    = config('app.env');
$dbHost    = config('database.connections.mysql.host');
$dbName    = config('database.connections.mysql.database');

// Test upload_url function
$testPath  = 'uploads/product_images/test.jpg';
$uploadUrl = upload_url($testPath);

// Test asset()
$assetUrl  = asset('uploads/product_images/test.jpg');

// Test DB connection
try {
    DB::connection()->getPdo();
    $dbStatus = '✅ Connected';
} catch (\Exception $e) {
    $dbStatus = '❌ ' . $e->getMessage();
}

// Test .env exists
$envExists = file_exists(dirname(__DIR__) . '/.env') ? '✅ Exists' : '❌ Missing';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Vivace - Environment Test</title>
<style>
body { font-family: monospace; background: #0f1117; color: #e2e8f0; padding: 30px; }
h2 { color: #818cf8; border-bottom: 1px solid #1e2130; padding-bottom: 10px; }
table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
th { background: #1e2130; color: #94a3b8; padding: 10px 14px; text-align: left; font-size: 0.75rem; text-transform: uppercase; }
td { padding: 10px 14px; border-bottom: 1px solid #1e2130; font-size: 0.9rem; }
td:first-child { color: #94a3b8; width: 200px; }
td:last-child { color: #f1f5f9; word-break: break-all; }
.ok  { color: #10b981 !important; }
.err { color: #ef4444 !important; }
</style>
</head>
<body>

<h2>🔍 Environment Info</h2>
<table>
    <tr><th>Key</th><th>Value</th></tr>
    <tr><td>.env file</td><td class="<?= str_starts_with($envExists,'✅') ? 'ok' : 'err' ?>"><?= $envExists ?></td></tr>
    <tr><td>APP_URL</td><td><?= htmlspecialchars($appUrl) ?></td></tr>
    <tr><td>APP_ENV</td><td><?= htmlspecialchars($appEnv) ?></td></tr>
    <tr><td>DB Host</td><td><?= htmlspecialchars($dbHost) ?></td></tr>
    <tr><td>DB Name</td><td><?= htmlspecialchars($dbName) ?></td></tr>
    <tr><td>DB Status</td><td class="<?= str_starts_with($dbStatus,'✅') ? 'ok' : 'err' ?>"><?= $dbStatus ?></td></tr>
</table>

<h2>🖼️ Image URL Test</h2>
<table>
    <tr><th>Function</th><th>Result</th></tr>
    <tr><td>upload_url('uploads/product_images/test.jpg')</td><td><?= htmlspecialchars($uploadUrl) ?></td></tr>
    <tr><td>asset('uploads/product_images/test.jpg')</td><td><?= htmlspecialchars($assetUrl) ?></td></tr>
    <tr><td>Expected (production)</td><td class="ok">https://vivacecollections.com/public/uploads/product_images/test.jpg</td></tr>
</table>

<h2>📁 Folder Check</h2>
<table>
    <tr><th>Path</th><th>Status</th></tr>
    <?php
    $folders = [
        'public/uploads',
        'public/uploads/product_images',
        'public/uploads/banners',
        'public/uploads/categories',
        'public/uploads/collection',
        'storage/logs',
    ];
    foreach($folders as $f) {
        $full = dirname(__DIR__) . '/' . $f;
        $exists = is_dir($full) ? '✅ Exists' : '❌ Missing';
        $cls = str_starts_with($exists,'✅') ? 'ok' : 'err';
        echo "<tr><td>{$f}</td><td class='{$cls}'>{$exists}</td></tr>";
    }
    ?>
</table>

<p style="color:#475569; font-size:0.75rem; margin-top:20px;">
    ⚠️ Delete this file after testing: <code>public/test.php</code>
</p>

</body>
</html>
