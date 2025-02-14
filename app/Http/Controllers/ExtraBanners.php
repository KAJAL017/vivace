<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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

        // If a new image is uploaded
        if ($request->hasFile('banner')) {
            // Get the new image file name
            $imageName = time() . '_' . $request->file('banner')->getClientOriginalName();
            $request->file('banner')->move(public_path('uploads/extrabanners'), $imageName);
            $imagePath = 'extrabanners/' . $imageName;
        } else {
            // If no new image is uploaded, use the current image path if updating
            if ($id) {
                $existingBanner = DB::table($tableName)->where('id', $id)->first();
                if ($existingBanner) {
                    $imagePath = $existingBanner->banner; // Keep the old banner if no new file is uploaded
                }
            }
        }

        // Check if the banner already exists (i.e., it's an update scenario)
        if ($id) {
            // Retrieve the existing banner record
            $existingBanner = DB::table($tableName)->where('id', $id)->first();

            // If there is an existing banner and a new image was uploaded, delete the old image
            if ($existingBanner && $imagePath && file_exists(public_path('uploads/' . $existingBanner->banner))) {
                // Delete the old image if it exists
                unlink(public_path('uploads/' . $existingBanner->banner));
            }

            // Update the banner data with the new image path (or keep the existing image if no new file)
            DB::table($tableName)->where('id', $id)->update([
                'banner' => $imagePath,
                'link' => $request->link, // Update other fields as necessary
            ]);

            return response()->json([
                'status' => 'success',
                'message' => "$bannerName Updated Successfully!"
            ], 200);
        } else {
            // Insert new banner data if no ID is provided (new record)
            DB::table($tableName)->insert([
                'banner' => $imagePath,
                'link' => $request->link,
            ]);

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
