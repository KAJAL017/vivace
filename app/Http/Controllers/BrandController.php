<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class BrandController extends Controller
{
    public function index()
    {
        $brands = DB::table('brands')->where(['is_deleted'=>0])->orderBy('id','DESC')->get();
        return view('admin.pages.brand.list',compact('brands'));
    }
    public function create()
    {
        return view('admin.pages.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240'
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
            $oldCategory = DB::table('brands')->where('id', $id)->first();
            $oldImagePath = $oldCategory->image ?? null;
        }

        $imagePath = $oldImagePath;
        if ($request->hasFile('image')) {
            // Generate a new name for the image
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/brands'), $imageName);
            $imagePath = 'brands/' . $imageName;

            // Delete the old image if it exists
            if ($oldImagePath && file_exists(public_path('uploads/' . $oldImagePath))) {
                unlink(public_path('uploads/' . $oldImagePath));
            }
        }

        $data = [
            'name' => $request->input('name'),
            'image' => $imagePath,
        ];

        if ($id) {
            DB::table('brands')->where('id', $id)->update($data);
            $message = 'Brand Updated Successfully!';
        } else {
            DB::table('brands')->insert($data);
            $message = 'Brand Created Successfully!';
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
    public function edit($id)
    {
        $brands = DB::table('brands')->where('id',$id)->first();
        if($brands){
           return view('admin.pages.brand.create',compact('brands'));
        }else{
            return redirect()->route('brand.index')->with('error','Something Error');
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
        $brands = DB::table('brands')->where('id',$id)->first();
        if ($brands) {
            DB::table('brands')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Brands Deleted Successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }
}
