<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImageKitService
{
    protected $publicKey;
    protected $privateKey;
    protected $urlEndpoint;
    protected $enabled;

    // Banner responsive sizes: [name => [width, height, quality]]
    // Height 0 = auto (maintain aspect ratio)
    const BANNER_SIZES = [
        'desktop' => ['width' => 1920, 'height' => 0, 'quality' => 85],
        'tablet'  => ['width' => 1024, 'height' => 0, 'quality' => 80],
        'mobile'  => ['width' => 768,  'height' => 0, 'quality' => 75],
    ];

    // Category image sizes — width only, height=0 means auto (no crop)
    const CATEGORY_SIZES = [
        'desktop' => ['width' => 600,  'height' => 0, 'quality' => 85],
        'tablet'  => ['width' => 400,  'height' => 0, 'quality' => 80],
        'mobile'  => ['width' => 300,  'height' => 0, 'quality' => 75],
    ];

    // Collection image sizes (portrait cards)
    const COLLECTION_SIZES = [
        'desktop' => ['width' => 600,  'height' => 0, 'quality' => 85],
        'tablet'  => ['width' => 400,  'height' => 0, 'quality' => 80],
        'mobile'  => ['width' => 300,  'height' => 0, 'quality' => 75],
    ];

    // Product image sizes — Shopify style responsive
    // desktop: 800px, tablet: 400px, mobile: 200px — all WebP
    const PRODUCT_SIZES = [
        'desktop' => ['width' => 800, 'height' => 0, 'quality' => 85],
        'tablet'  => ['width' => 400, 'height' => 0, 'quality' => 80],
        'mobile'  => ['width' => 200, 'height' => 0, 'quality' => 75],
    ];

    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * Load ImageKit settings from database
     */
    private function loadSettings()
    {
        $settings = DB::table('settings')->first();

        $this->publicKey    = $settings->imagekit_public_key    ?? '';
        $this->privateKey   = $settings->imagekit_private_key   ?? '';
        $this->urlEndpoint  = $settings->imagekit_url_endpoint  ?? '';
        $this->enabled      = $settings->imagekit_enabled       ?? 0;
    }

    /**
     * Check if ImageKit is enabled and configured
     */
    public function isEnabled()
    {
        return $this->enabled == 1 &&
               !empty($this->publicKey) &&
               !empty($this->privateKey) &&
               !empty($this->urlEndpoint);
    }

    /**
     * Upload image to ImageKit
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @param string|null $fileName
     * @return array|null
     */
    public function uploadImage($file, $folder = 'products', $fileName = null)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            if (!$fileName) {
                $fileName = time() . '_' . $file->getClientOriginalName();
            }

            $realPath = $file->getRealPath();
            if (!$realPath || !file_exists($realPath)) {
                Log::error('ImageKit upload: file not found', ['path' => $realPath]);
                return null;
            }

            $fileContent = base64_encode(file_get_contents($realPath));
            $uploadUrl   = 'https://upload.imagekit.io/api/v1/files/upload';

            $response = Http::timeout(60)
                ->withBasicAuth($this->privateKey, '')
                ->asMultipart()
                ->post($uploadUrl, [
                    ['name' => 'file',              'contents' => $fileContent],
                    ['name' => 'fileName',          'contents' => $fileName],
                    ['name' => 'folder',            'contents' => $folder],
                    ['name' => 'useUniqueFileName', 'contents' => 'true'],
                ]);

            if ($response->successful()) {
                $data = $response->json();

                // ImageKit API does NOT return a 'success' key — check fileId
                if (empty($data['fileId'])) {
                    Log::error('ImageKit upload: unexpected response', ['body' => $response->body()]);
                    return null;
                }

                return [
                    'success'       => true,
                    'file_id'       => $data['fileId']       ?? '',
                    'file_name'     => $data['name']         ?? $fileName,
                    'file_path'     => $data['filePath']     ?? '',
                    'url'           => $data['url']          ?? '',
                    'thumbnail_url' => $data['thumbnailUrl'] ?? '',
                    'width'         => $data['width']        ?? 0,
                    'height'        => $data['height']       ?? 0,
                    'size'          => $data['size']         ?? 0,
                ];
            }

            Log::error('ImageKit upload failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('ImageKit upload exception', [
                'message' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Upload video to ImageKit (mp4, webm, mov etc.)
     * Same API as image upload — ImageKit supports video files too.
     */
    public function uploadVideo($file, $folder = 'reels', $fileName = null)
    {
        if (!$this->isEnabled()) {
            return null;
        }

        try {
            if (!$fileName) {
                $fileName = time() . '_' . $file->getClientOriginalName();
            }

            $realPath = $file->getRealPath();
            if (!$realPath || !file_exists($realPath)) {
                Log::error('ImageKit video upload: file not found', ['path' => $realPath]);
                return null;
            }

            // For large videos use stream instead of base64
            $fileContent = base64_encode(file_get_contents($realPath));
            $uploadUrl   = 'https://upload.imagekit.io/api/v1/files/upload';

            $response = Http::timeout(120)
                ->withBasicAuth($this->privateKey, '')
                ->asMultipart()
                ->post($uploadUrl, [
                    ['name' => 'file',              'contents' => $fileContent],
                    ['name' => 'fileName',          'contents' => $fileName],
                    ['name' => 'folder',            'contents' => $folder],
                    ['name' => 'useUniqueFileName', 'contents' => 'true'],
                ]);

            if ($response->successful()) {
                $data = $response->json();
                if (empty($data['fileId'])) {
                    Log::error('ImageKit video upload: unexpected response', ['body' => $response->body()]);
                    return null;
                }
                return [
                    'success'   => true,
                    'file_id'   => $data['fileId'] ?? '',
                    'file_name' => $data['name']   ?? $fileName,
                    'file_path' => $data['filePath'] ?? '',
                    'url'       => $data['url']     ?? '',
                ];
            }

            Log::error('ImageKit video upload failed', ['status' => $response->status(), 'body' => $response->body()]);
            return null;

        } catch (\Exception $e) {
            Log::error('ImageKit video upload exception', ['message' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Delete image from ImageKit
     *
     * @param string $fileId
     * @return bool
     */
    public function deleteImage($fileId)
    {
        if (!$this->isEnabled() || empty($fileId)) {
            return false;
        }

        try {
            $response = Http::withBasicAuth($this->privateKey, '')
                ->delete("https://api.imagekit.io/v1/files/{$fileId}");

            return $response->successful();
        } catch (\Exception $e) {
            Log::error('ImageKit delete exception', ['message' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Build an ImageKit URL with on-the-fly transformations.
     * ImageKit handles resize + WebP conversion on CDN — no extra upload needed.
     *
     * @param string $filePath   e.g. "banners/filename.jpg"
     * @param int    $width      target width in px
     * @param int    $height     target height (0 = auto)
     * @param int    $quality    1-100
     * @return string
     */
    public function buildTransformUrl($filePath, $width, $height = 0, $quality = 80)
    {
        $endpoint = rtrim($this->urlEndpoint, '/');
        $path     = ltrim($filePath, '/');

        $params = ["w-{$width}", "f-webp", "q-{$quality}"];
        if ($height > 0) {
            $params[] = "h-{$height}";
            $params[] = "c-at_max"; // crop mode: fit within box
        }

        $tr = 'tr:' . implode(',', $params);
        return "{$endpoint}/{$tr}/{$path}";
    }

    /**
     * Generate all responsive banner URLs from a single uploaded file path.
     * Uses ImageKit URL-based transformations — no extra uploads needed.
     *
     * @param string $filePath  ImageKit file path (e.g. "banners/filename.jpg")
     * @return array  ['desktop' => url, 'tablet' => url, 'mobile' => url]
     */
    public function getBannerResponsiveUrls($filePath)
    {
        return $this->getResponsiveUrls($filePath, self::BANNER_SIZES);
    }

    /**
     * Generate responsive category image URLs.
     *
     * @param string $filePath
     * @return array ['desktop' => url, 'tablet' => url, 'mobile' => url]
     */
    public function getCategoryResponsiveUrls($filePath)
    {
        return $this->getResponsiveUrls($filePath, self::CATEGORY_SIZES);
    }

    /**
     * Generic: generate responsive URLs for any size config.
     *
     * @param string $filePath
     * @param array  $sizes   e.g. ['desktop'=>['width'=>...,'height'=>...,'quality'=>...], ...]
     * @return array
     */
    public function getResponsiveUrls($filePath, array $sizes)
    {
        $urls = [];
        foreach ($sizes as $size => $cfg) {
            $urls[$size] = $this->buildTransformUrl(
                $filePath,
                $cfg['width'],
                $cfg['height'],
                $cfg['quality']
            );
        }
        return $urls;
    }

    /**
     * Upload image with fallback to local storage.
     * On ImageKit success, also generates responsive URLs.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $localPath        e.g. 'uploads/banners'
     * @param string $imagekitFolder   e.g. 'banners'
     * @param array|null $sizeConfig   null = use BANNER_SIZES, or pass custom sizes
     * @return array
     */
    public function uploadWithFallback($file, $localPath, $imagekitFolder = 'products', $sizeConfig = null)
    {
        $result = [
            'uploaded_to_imagekit'  => false,
            'file_name'             => '',
            'file_path'             => '',
            'imagekit_file_id'      => null,
            'imagekit_url'          => null,
            'imagekit_url_desktop'  => null,
            'imagekit_url_tablet'   => null,
            'imagekit_url_mobile'   => null,
        ];

        $fileName = time() . '_' . $file->getClientOriginalName();

        // Try ImageKit upload first
        if ($this->isEnabled()) {
            $imagekitResult = $this->uploadImage($file, $imagekitFolder, $fileName);

            if ($imagekitResult && $imagekitResult['success']) {
                $filePath = ltrim($imagekitResult['file_path'], '/');

                // Use provided size config or default to BANNER_SIZES
                $sizes = $sizeConfig ?? self::BANNER_SIZES;
                $responsiveUrls = $this->getResponsiveUrls($filePath, $sizes);

                $result['uploaded_to_imagekit'] = true;
                $result['file_name']            = $imagekitResult['file_name'];
                $result['file_path']            = $filePath;
                $result['imagekit_file_id']     = $imagekitResult['file_id'];
                $result['imagekit_url']         = $imagekitResult['url'];
                $result['imagekit_url_desktop'] = $responsiveUrls['desktop'];
                $result['imagekit_url_tablet']  = $responsiveUrls['tablet'];
                $result['imagekit_url_mobile']  = $responsiveUrls['mobile'];

                return $result;
            }
        }

        // Fallback: save to local storage
        $destinationPath = public_path($localPath);
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $fileName);

        // Store only 'folder/filename.jpg' (no 'uploads/' prefix)
        $result['file_name'] = $fileName;
        $result['file_path'] = ltrim(str_replace('uploads/', '', $localPath), '/') . '/' . $fileName;

        return $result;
    }

    /**
     * Get optimized image URL with custom transformations (generic helper)
     *
     * @param string $filePath
     * @param array  $transformations  ['width'=>, 'height'=>, 'quality'=>, 'format'=>]
     * @return string
     */
    public function getImageUrl($filePath, $transformations = [])
    {
        if (!$this->isEnabled() || empty($filePath)) {
            return $filePath;
        }

        $endpoint = rtrim($this->urlEndpoint, '/');
        $path     = ltrim($filePath, '/');

        if (empty($transformations)) {
            return "{$endpoint}/{$path}";
        }

        $params = [];
        if (isset($transformations['width']))   $params[] = 'w-' . $transformations['width'];
        if (isset($transformations['height']))  $params[] = 'h-' . $transformations['height'];
        if (isset($transformations['quality'])) $params[] = 'q-' . $transformations['quality'];
        if (isset($transformations['format']))  $params[] = 'f-' . $transformations['format'];

        if (empty($params)) {
            return "{$endpoint}/{$path}";
        }

        $tr = 'tr:' . implode(',', $params);
        return "{$endpoint}/{$tr}/{$path}";
    }
}
