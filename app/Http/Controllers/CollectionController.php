<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('collections')
            ->select('collections.*','sub_categories.name as categoryname')
            ->leftJoin('sub_categories','sub_categories.id','collections.sub_category_id')
            ->where('collections.is_deleted',0);
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $query->where('collections.name', 'like', '%' . $request->search . '%');
        }
        
        // Subcategory filter
        if ($request->has('subcategory') && $request->subcategory != '') {
            $query->where('collections.sub_category_id', $request->subcategory);
        }
        
        $collections = $query->orderBy('collections.id','DESC')->paginate(10);
        
        // Get all subcategories for filter dropdown
        $subcategories = DB::table('sub_categories')
            ->where('is_deleted', 0)
            ->orderBy('name', 'ASC')
            ->get();

        // Check if it's an AJAX request
        if ($request->ajax()) {
            $tableHtml = view('admin.pages.collections.partials.collection-table', compact('collections'))->render();
            $paginationHtml = view('admin.pages.collections.partials.pagination', compact('collections'))->render();
            
            return response()->json([
                'table' => $tableHtml,
                'pagination' => $paginationHtml
            ]);
        }

        return view('admin.pages.collections.list', compact('collections', 'subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.collections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
    $request->validate([
        'collection_name' => 'required|string|max:255',
        'sub_category' => 'required|integer',
        'collection_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,heic|max:2048',
    ]);

    try {
        $imagePath = null;

        // Check if image is uploaded
        if ($request->hasFile('collection_image')) {
            $imageName = time() . '_' . $request->file('collection_image')->getClientOriginalName();
            $request->file('collection_image')->move(public_path('uploads/collection'), $imageName);
            $imagePath = 'collection/' . $imageName;
        }

        // Check if it's an update or create operation
        if ($request->id) {
            $data = [
                'name' => $request->collection_name,
                'sub_category_id' => $request->sub_category,
            ];

            // Only update image if a new one is uploaded
            if ($imagePath) {
                $data['image_path'] = $imagePath;
            }

            DB::table('collections')->where('id', $request->id)->update($data);

            $message = 'Collection updated successfully.';
        } else {
            // Insert a new collection
            DB::table('collections')->insert([
                'name' => $request->collection_name,
                'sub_category_id' => $request->sub_category,
                'image_path' => $imagePath,
            ]);

            $message = 'Collection added successfully.';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong. Please try again later.',
        ]);
    }
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
        $collections = DB::table('collections')->where('id',$id)->first();
        if($collections){
           return view('admin.pages.collections.create',compact('collections'));
        }else{
            return redirect()->route('collections.index')->with('error','Something Error');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     $request->validate([
    //         'collection_name' => 'required|string|max:255',
    //     ]);

    //     DB::table('collections')->where('id', $request->collection_id)->update([
    //         'name' => $request->collection_name,
    //         'updated_at' => now()
    //     ]);

    //     return response()->json(['success' => true, 'message' => 'Collection updated successfully!']);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $collections = DB::table('collections')->where('id',$id)->first();
        if ($collections) {
            DB::table('collections')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }
}
