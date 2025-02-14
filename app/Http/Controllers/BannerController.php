<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
         if ($id) {
             // Get the existing category and image path
             $oldCategory = DB::table('banners')->where('id', $id)->first();
             $oldImagePath = $oldCategory->banner ?? null;
         }

         $imagePath = $oldImagePath;
         if ($request->hasFile('banner')) {
             // Generate a new name for the image
             $imageName = time() . '_' . $request->file('banner')->getClientOriginalName();
             $request->file('banner')->move(public_path('uploads/banners'), $imageName);
             $imagePath = 'banners/' . $imageName;

             // Delete the old image if it exists
             if ($oldImagePath && file_exists(public_path('uploads/' . $oldImagePath))) {
                 unlink(public_path('uploads/' . $oldImagePath));
             }
         }

         $data = [

             'banner' => $imagePath,
             'url' => $request->url,
             'index_number' => $request->index,
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
