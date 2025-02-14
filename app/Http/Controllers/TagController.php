<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index()
    {
        $tags = DB::table('tags')->where(['is_deleted'=>0])->orderBy('id','DESC')->get();
        return view('admin.pages.tags.list',compact('tags'));
    }
    public function create()
    {
        return view('admin.pages.tags.create');
    }
    public function store(Request $request)
    {
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tags', 'name')
                    ->ignore($id)
                    ->where(function ($query) {
                        $query->where('is_deleted', 0);
                    }),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $data = [
            'name' => $request->input('name')
        ];

        if ($id) {
            DB::table('tags')->where('id', $id)->update($data);
            $message = 'Tag Updated Successfully!';
        } else {
            DB::table('tags')->insert($data);
            $message = 'Tag Created Successfully!';
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
        $tags = DB::table('tags')->where('id',$id)->first();
        if($tags){
           return view('admin.pages.tags.create',compact('tags'));
        }else{
            return redirect()->route('tag.index')->with('error','Something Error');
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
        $tags = DB::table('tags')->where('id',$id)->first();
        if ($tags) {
            DB::table('tags')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Tag deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Tag not found.']);
    }
}
