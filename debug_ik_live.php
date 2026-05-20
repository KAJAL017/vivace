<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;

$settings = DB::table('settings')->first();
$privateKey  = $settings->imagekit_private_key;
$urlEndpoint = $settings->imagekit_url_endpoint;

echo "=== Testing ImageKit Upload API directly ===\n";

// Use a real small image from public folder
$testFile = __DIR__ . '/public/android-chrome-192x192.png';
if (!file_exists($testFile)) {
    // find any image
    $files = glob(__DIR__ . '/public/*.png');
    $testFile = $files[0] ?? null;
}

if (!$testFile) {
    echo "No test image found!\n";
    exit;
}

echo "Test file: $testFile\n";
echo "File exists: " . (file_exists($testFile) ? 'YES' : 'NO') . "\n";
echo "File size: " . filesize($testFile) . " bytes\n";

$fileContent = base64_encode(file_get_contents($testFile));
$fileName    = 'debug_test_' . time() . '.png';

$response = Http::withBasicAuth($privateKey, '')
    ->asMultipart()
    ->post('https://upload.imagekit.io/api/v1/files/upload', [
        ['name' => 'file',              'contents' => $fileContent],
        ['name' => 'fileName',          'contents' => $fileName],
        ['name' => 'folder',            'contents' => 'debug'],
        ['name' => 'useUniqueFileName', 'contents' => 'true'],
    ]);

echo "\nHTTP Status: " . $response->status() . "\n";
echo "successful(): " . ($response->successful() ? 'YES' : 'NO') . "\n";
$data = $response->json();
echo "fileId: " . ($data['fileId'] ?? 'NOT PRESENT') . "\n";
echo "url: "    . ($data['url']    ?? 'NOT PRESENT') . "\n";

if (!empty($data['message'])) {
    echo "Error message: " . $data['message'] . "\n";
}

// Check PHP upload settings
echo "\n=== PHP Upload Settings ===\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: "       . ini_get('post_max_size') . "\n";
echo "max_execution_time: "  . ini_get('max_execution_time') . "\n";
echo "memory_limit: "        . ini_get('memory_limit') . "\n";
