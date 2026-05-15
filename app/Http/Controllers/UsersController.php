<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DB::table('users')->orderBy('id', 'DESC');
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $users = $query->paginate(10);
        
        // Stats
        $total_users = DB::table('users')->count();
        $users_with_orders = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->distinct('users.id')
            ->count('users.id');
        $total_orders = DB::table('orders')->count();
        
        // AJAX request
        if ($request->ajax()) {
            $html = view('admin.pages.users.partials.users-table', compact('users'))->render();
            $pagination = view('admin.pages.users.partials.pagination', compact('users'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination
            ]);
        }
        
        return view('admin.pages.users.list', compact('users', 'total_users', 'users_with_orders', 'total_orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found'
            ], 404);
        }
        
        // Get user's orders
        $orders = DB::table('orders')
            ->where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->get();
        
        // Get user's addresses
        $addresses = DB::table('addresses')
            ->where('user_id', $id)
            ->get();
        
        // Calculate stats
        $total_orders = DB::table('orders')->where('user_id', $id)->count();
        $total_spent = DB::table('orders')->where('user_id', $id)->sum('total_amount');
        $pending_orders = DB::table('orders')->where('user_id', $id)->where('status', 'pending')->count();
        
        $html = view('admin.pages.users.partials.user-details', compact('user', 'orders', 'addresses', 'total_orders', 'total_spent', 'pending_orders'))->render();
        
        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
        //
    }
}
