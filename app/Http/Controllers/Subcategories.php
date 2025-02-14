<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class Subcategories extends Controller
{

    public function index()
    {
        $sub_categories = DB::table('sub_categories')
        ->select('sub_categories.*','categories.name as categoryname')
        ->join('categories','categories.id','=','sub_categories.category_id')
        ->where(['sub_categories.is_deleted'=>0])
        ->orderBy('sub_categories.id','DESC')
        ->get();
        return view('admin.pages.subcategory.list',compact('sub_categories'));
    }
    public function create()
    {
        return view('admin.pages.subcategory.create');
    }
    public function edit($id)
    {

        $sub_categories = DB::table('sub_categories')->where('id',$id)->first();
        if($sub_categories){
           return view('admin.pages.subcategory.create',compact('sub_categories'));
        }else{
            return redirect()->route('subcategories.index')->with('error','Something Error');
        }
    }

    public function store(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'show_in_top_bar' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $oldImagePath = null;
        if ($id) {
            $sub_categories = DB::table('sub_categories')->where('id', $id)->first();
            $oldImagePath = $sub_categories->image ?? null;
        }

        $imagePath = $oldImagePath;
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/sub_categories'), $imageName);
            $imagePath = 'public/uploads/sub_categories/' . $imageName;

            // Delete the old image if it exists
            if ($oldImagePath && file_exists(public_path($oldImagePath))) {
                unlink(public_path($oldImagePath));
            }
        }



        $data = [
            'name' => $request->input('name'),
            'category_id' => $request->input('category'),
            'show_in_top_bar' => $request->boolean('show_in_top_bar'),
            'slug' => \Illuminate\Support\Str::slug($request->input('name')),
            'image' => $imagePath
        ];

        if ($id) {
            DB::table('sub_categories')->where('id', $id)->update($data);
            $message = 'Sub Category Updated successfully!';
        } else {
            DB::table('sub_categories')->insert($data);
            $message = 'Sub  Category Created successfully!';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message
        ], 200);

    }
    public function destroy($id)
    {
        $sub_categories = DB::table('sub_categories')->where('id',$id)->first();
        if ($sub_categories) {
            DB::table('sub_categories')->where('id',$id)->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }
}
