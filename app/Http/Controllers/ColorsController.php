<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ColorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = DB::table('colors')->where(['is_deleted'=>0])->orderBy('id','DESC')->get();
        return view('admin.pages.colors.list',compact('colors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.colors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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
            'hex_code' => $request->input('hex_code')
        ];

        if ($id) {
            DB::table('colors')->where('id', $id)->update($data);
            $message = 'Color Updated Successfully!';
        } else {
            DB::table('colors')->insert($data);
            $message = 'Color Created Successfully!';
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
        $colors = DB::table('colors')->where('id',$id)->first();
        if($colors){
           return view('admin.pages.colors.create',compact('colors'));
        }else{
            return redirect()->route('color.index')->with('error','Something Error');
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
    public function destroy(string $id)
    {
        $colors = DB::table('colors')->where('id',$id)->first();
        if ($colors) {
            DB::table('colors')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Color deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Color not found.']);
    }
}
