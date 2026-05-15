<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('coupons')->where('is_deleted', 0);
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('coupon_code', 'like', '%' . $search . '%');
        }
        
        // Status filter
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }
        
        // Type filter
        if ($request->has('type') && $request->type !== '') {
            $query->where('coupon_type', $request->type);
        }
        
        // Pagination
        $coupons = $query->orderBy('id', 'desc')->paginate(10);
        
        // Stats
        $total_coupons = DB::table('coupons')->where('is_deleted', 0)->count();
        $active_coupons = DB::table('coupons')->where('is_deleted', 0)->where('status', 1)->count();
        $percentage_coupons = DB::table('coupons')->where('is_deleted', 0)->where('coupon_type', 1)->count();
        
        // AJAX request
        if ($request->ajax()) {
            $html = view('admin.pages.coupon.partials.coupon-table', compact('coupons'))->render();
            $pagination = view('admin.pages.coupon.partials.pagination', compact('coupons'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination
            ]);
        }
        
        return view('admin.pages.coupon.list', compact('coupons', 'total_coupons', 'active_coupons', 'percentage_coupons'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('admin.pages.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id = $request->id;

        $validator = Validator::make($request->all(), [
          'coupon_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('coupons', 'coupon_code')
                    ->ignore($id)
                    ->where(function ($query) {
                        $query->where('is_deleted', 0);
                    }),
                ],
            'status' => 'required',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
            'coupon_type' => 'required',
            'discount_value' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }
        $startDate = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('d-m-Y');
        $endDate = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('d-m-Y');

        $data = [
            'coupon_code' => $request->coupon_code,
            'status' => $request->status,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'coupon_type' => $request->coupon_type,
            'discount_value' => $request->discount_value,
            'timestamps' => now(),
        ];

        if($id){
            DB::table('coupons')->where(['id'=>$id])->update($data);
            $message = 'Coupon Update Successfully!';
        }else{
            DB::table('coupons')->insert($data);
            $message = 'Coupon Created Successfully!';
        }



        return response()->json([
            'status' => 'success',
            'message' => $message
        ]);
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $coupons = DB::table('coupons')->where('id',$id)->first();
        if($coupons){
           return view('admin.pages.coupon.create',compact('coupons'));
        }else{
            return redirect()->route('coupon.index')->with('error','Something Error');
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
        $coupons = DB::table('coupons')->where('id',$id)->first();
        if ($coupons) {
            DB::table('coupons')->where('id',$id)->update(['is_deleted'=>1]);
            return response()->json(['success' => true, 'message' => 'Coupon deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Coupon not found.']);
    }
}
