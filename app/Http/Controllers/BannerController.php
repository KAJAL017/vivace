<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Services\ImageKitService;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $banners = DB::table('banners')
        ->where(['is_deleted'=>0])
        // ->whereNotNull('index_number')
        ->orderBy('index_number', 'asc')
        ->get();
        return view('admin.pages.banner.list',compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $id = $request->id;
         if($id){
               $image_validfation  = 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240';
         }else{
              $image_validfation  = 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240';
         }

         $validator = Validator::make($request->all(), [
             'banner' =>  $image_validfation,

         ]);

         if ($validator->fails()) {
             return response()->json([
                 'status' => 'error',
                 'errors' => $validator->errors()
             ], 422);
         }

         $oldImagePath = null;
         $oldImagekitFileId = null;
         if ($id) {
             // Get the existing banner and image details
             $oldBanner = DB::table('banners')->where('id', $id)->first();
             $oldImagePath          = $oldBanner->banner              ?? null;
             $oldImagekitFileId     = $oldBanner->imagekit_file_id    ?? null;
         }

         $imagePath          = $oldImagePath;
         $imagekitFileId     = $oldImagekitFileId;
         $imagekitUrl        = null;
         $imagekitUrlDesktop = null;
         $imagekitUrlTablet  = null;
         $imagekitUrlMobile  = null;
         $uploadedToImagekit = false;

         // Preserve existing responsive URLs if no new file uploaded (update case)
         if ($id && isset($oldBanner)) {
             $imagekitUrl        = $oldBanner->imagekit_url         ?? null;
             $imagekitUrlDesktop = $oldBanner->imagekit_url_desktop ?? null;
             $imagekitUrlTablet  = $oldBanner->imagekit_url_tablet  ?? null;
             $imagekitUrlMobile  = $oldBanner->imagekit_url_mobile  ?? null;
             $uploadedToImagekit = $oldBanner->uploaded_to_imagekit ?? 0;
         }

         if ($request->hasFile('banner')) {
             $imagekitService = new ImageKitService();

             // Upload to ImageKit (with local fallback)
             $uploadResult = $imagekitService->uploadWithFallback(
                 $request->file('banner'),
                 'uploads/banners',
                 'banners'
             );

             \Illuminate\Support\Facades\Log::info('Banner upload result', $uploadResult);

             $uploadedToImagekit = $uploadResult['uploaded_to_imagekit'];

             if ($uploadedToImagekit) {
                 // ImageKit pe upload hua — responsive URLs bhi save karo
                 $imagePath          = $uploadResult['file_path'];
                 $imagekitFileId     = $uploadResult['imagekit_file_id'];
                 $imagekitUrl        = $uploadResult['imagekit_url'];
                 $imagekitUrlDesktop = $uploadResult['imagekit_url_desktop'];
                 $imagekitUrlTablet  = $uploadResult['imagekit_url_tablet'];
                 $imagekitUrlMobile  = $uploadResult['imagekit_url_mobile'];
             } else {
                 // Local fallback
                 $imagePath          = $uploadResult['file_path'];
                 $imagekitFileId     = null;
                 $imagekitUrl        = null;
                 $imagekitUrlDesktop = null;
                 $imagekitUrlTablet  = null;
                 $imagekitUrlMobile  = null;
             }

             // Delete old image
             if ($oldImagePath) {
                 // Delete from ImageKit if it was stored there
                 if ($oldImagekitFileId && $imagekitService->isEnabled()) {
                     $imagekitService->deleteImage($oldImagekitFileId);
                 }
                 
                 // Delete from local storage if it exists
                 $localPath = 'uploads/' . $oldImagePath;
                 if (file_exists(public_path($localPath))) {
                     unlink(public_path($localPath));
                 }
             }
         }

         $data = [
             'banner'                => $imagePath,
             'url'                   => $request->url,
             'index_number'          => $request->index,
             'imagekit_file_id'      => $imagekitFileId,
             'imagekit_url'          => $imagekitUrl,
             'imagekit_url_desktop'  => $imagekitUrlDesktop ?? null,
             'imagekit_url_tablet'   => $imagekitUrlTablet  ?? null,
             'imagekit_url_mobile'   => $imagekitUrlMobile  ?? null,
             'uploaded_to_imagekit'  => $uploadedToImagekit ? 1 : 0,
         ];

         if ($id) {
             DB::table('banners')->where('id', $id)->update($data);
             $message = 'Banner Updated Successfully!';
         } else {
             DB::table('banners')->insert($data);
             $message = 'Banner Created Successfully!';
         }

         return response()->json([
             'status' => 'success',
             'message' => $message
         ], 200);
     }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banners = DB::table('banners')->where('id',$id)->first();
        if($banners){
           return view('admin.pages.banner.create',compact('banners'));
        }else{
            return redirect()->route('banner.index')->with('error','Something Error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Toggle banner active/inactive status
     */
    public function toggleActive(Request $request)
    {
        $id = $request->id;
        $banner = DB::table('banners')->where('id', $id)->where('is_deleted', 0)->first();

        if (!$banner) {
            return response()->json(['success' => false, 'message' => 'Banner not found.']);
        }

        $newStatus = $banner->is_active ? 0 : 1;
        DB::table('banners')->where('id', $id)->update(['is_active' => $newStatus]);

        return response()->json([
            'success'   => true,
            'is_active' => $newStatus,
            'message'   => $newStatus ? 'Banner activated.' : 'Banner deactivated.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $banners = DB::table('banners')->find($id);
        if ($banners) {
            DB::table('banners')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Banner Deleted Successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Banner not found.']);
    }
}
