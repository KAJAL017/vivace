<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Services\ImageKitService;

class ExtraBanners extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.extrabanner.create');
    }

    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function store1(Request $request)
    {
        return $this->storeBanner($request, 'Banner 1', 'banner_table_1');
    }

    public function store2(Request $request)
    {
        return $this->storeBanner($request, 'Banner 2', 'banner_table_2');
    }

    public function store3(Request $request)
    {
        return $this->storeBanner($request, 'Banner 3', 'banner_table_3');
    }

    public function store4(Request $request)
    {
        return $this->storeBanner($request, 'Banner 4', 'banner_table_4');
    }

    private function storeBanner(Request $request, $bannerName, $tableName)
    {
        // Validation for the banner image (only required if a new image is uploaded)
        $validator = Validator::make($request->all(), [
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Get the ID from the request
        $id = $request->id;
        $imagePath = null;
        $imagekitFileId = null;
        $imagekitUrl = null;
        $uploadedToImagekit = false;

        // If a new image is uploaded
        if ($request->hasFile('banner')) {
            $imagekitService = new ImageKitService();
            
            // Try to upload to ImageKit with fallback to local
            $uploadResult = $imagekitService->uploadWithFallback(
                $request->file('banner'),
                'uploads/extrabanners',
                'extrabanners'
            );

            $imagePath = $uploadResult['file_path'];
            $uploadedToImagekit = $uploadResult['uploaded_to_imagekit'];
            
            if ($uploadedToImagekit) {
                $imagekitFileId = $uploadResult['imagekit_file_id'];
                $imagekitUrl = $uploadResult['imagekit_url'];
            }

            // If updating, delete the old image
            if ($id) {
                $existingBanner = DB::table($tableName)->where('id', $id)->first();
                if ($existingBanner) {
                    // Delete from ImageKit if it was stored there
                    if (!empty($existingBanner->imagekit_file_id) && $imagekitService->isEnabled()) {
                        $imagekitService->deleteImage($existingBanner->imagekit_file_id);
                    }
                    
                    // Delete from local storage if it exists
                    $localPath = 'uploads/' . $existingBanner->banner;
                    if (!empty($existingBanner->banner) && file_exists(public_path($localPath))) {
                        unlink(public_path($localPath));
                    }
                }
            }
        } else {
            // If no new image is uploaded, use the current image path if updating
            if ($id) {
                $existingBanner = DB::table($tableName)->where('id', $id)->first();
                if ($existingBanner) {
                    $imagePath = $existingBanner->banner;
                    $imagekitFileId = $existingBanner->imagekit_file_id ?? null;
                    $imagekitUrl = $existingBanner->imagekit_url ?? null;
                    $uploadedToImagekit = $existingBanner->uploaded_to_imagekit ?? false;
                }
            }
        }

        // Prepare data for insert/update
        $data = [
            'banner' => $imagePath,
            'link' => $request->link,
            'imagekit_file_id' => $imagekitFileId,
            'imagekit_url' => $imagekitUrl,
            'uploaded_to_imagekit' => $uploadedToImagekit ? 1 : 0,
        ];

        // Check if the banner already exists (i.e., it's an update scenario)
        if ($id) {
            // Update the banner data
            DB::table($tableName)->where('id', $id)->update($data);

            return response()->json([
                'status' => 'success',
                'message' => "$bannerName Updated Successfully!"
            ], 200);
        } else {
            // Insert new banner data if no ID is provided (new record)
            DB::table($tableName)->insert($data);

            return response()->json([
                'status' => 'success',
                'message' => "$bannerName Created Successfully!"
            ], 200);
        }
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
