<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{

    public function index(Request $request)
    {
        $query = DB::table('sizes')->where('is_deleted', 0);
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Always paginate
        $sizes = $query->orderBy('id', 'DESC')->paginate(10);
        
        // Append query parameters to pagination links
        $sizes->appends($request->only(['search']));
        
        // Check if it's an AJAX request
        if ($request->ajax()) {
            $tableHtml = view('admin.pages.size.partials.size-table', compact('sizes'))->render();
            $paginationHtml = view('admin.pages.size.partials.pagination', compact('sizes'))->render();
            
            return response()->json([
                'table' => $tableHtml,
                'pagination' => $paginationHtml
            ]);
        }
        
        return view('admin.pages.size.list', compact('sizes'));
    }
    public function create()
    {
        return view('admin.pages.size.create');
    }
    public function store(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }



        $data = [
            'name' => $request->input('name'),
];

        if ($id) {
            DB::table('sizes')->where('id', $id)->update($data);
            $message = 'Size Updated Successfully!';
        } else {
            DB::table('sizes')->insert($data);
            $message = 'Size Created Successfully!';
        }

        return response()->json([
            'status' => 'success',
            'message' => $message
        ], 200);
    }

    public function edit($id)
    {
        $categories = DB::table('sizes')->where('id',$id)->first();
        if($categories){
           return view('admin.pages.size.create',compact('categories'));
        }else{
            return redirect()->route('size.index')->with('error','Something Error');
        }
    }

    public function destroy(string $id)
    {
        $category = DB::table('sizes')->where('id',$id)->first();
        if ($category) {
            DB::table('sizes')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Category not found.']);
    }
}
