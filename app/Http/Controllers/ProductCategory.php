<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('categories')->where('is_deleted', 0);
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Always paginate
        $categories = $query->orderBy('id', 'DESC')->paginate(10);
        
        // Append query parameters to pagination links
        $categories->appends($request->only(['search']));
        
        // Check if it's an AJAX request
        if ($request->ajax()) {
            $tableHtml = view('admin.pages.category.partials.category-table', compact('categories'))->render();
            $paginationHtml = view('admin.pages.category.partials.pagination', compact('categories'))->render();
            
            return response()->json([
                'table' => $tableHtml,
                'pagination' => $paginationHtml
            ]);
        }
        
        return view('admin.pages.category.list', compact('categories'));
    }
    public function create()
    {
        return view('admin.pages.category.create');
    }
    public function store(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,heic|max:2048', // Allow null image
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
            // Get the existing category and image path
            $oldCategory = DB::table('categories')->where('id', $id)->first();
            $oldImagePath = $oldCategory->image ?? null;
        }

        $imagePath = $oldImagePath;
        if ($request->hasFile('image')) {
            // Generate a new name for the image
            $imageName = time() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('uploads/categories'), $imageName);
            $imagePath = 'categories/' . $imageName;


            if ($oldImagePath && file_exists(public_path('uploads/' . $oldImagePath))) {
                unlink(public_path('uploads/' . $oldImagePath));
            }
        }

        $data = [
            'name' => $request->input('name'),
            'image' => $imagePath,
            'show_in_top_bar' => $request->boolean('show_in_top_bar'),
        ];

        if ($id) {
            DB::table('categories')->where('id', $id)->update($data);
            $message = 'Category updated successfully!';
        } else {
            DB::table('categories')->insert($data);
            $message = 'Category created successfully!';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message
        ], 200);
    }

    public function edit(Request $request ,$id)
    {
       $categories = DB::table('categories')->where('id',$id)->first();
        if($categories){
           return view('admin.pages.category.create',compact('categories'));
        }else{
            return redirect()->route('category.index')->with('error','Something Error');
        }
    }
    public function destroy($id)
    {
        $category = DB::table('categories')->where('id',$id)->first();
        if ($category) {
            DB::table('categories')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }
     public function getSubcategories(Request $request)
    {
        // Fetch subcategories based on the selected category_id
        $subcategories = DB::table('sub_categories')
            ->where('category_id', $request->category_id)
            ->where('is_deleted', 0)
            ->get();

        // Return the subcategories as a JSON response
        return response()->json([
            'subcategories' => $subcategories
        ]);
    }

}
