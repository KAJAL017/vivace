<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function login(){
        return view('admin.pages.auth.login');
    }
    public function auth(Request $request)    {
        // Handle verification code only request
        if ($request->has('verification_only') && $request->verification_only) {
            if ($request->code === '18') {
                session(['admin_verified' => true]);
                return response()->json([
                    'success' => true,
                    'message' => 'Verification successful',
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code',
            ], 401);
        }

        // Handle login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = DB::table('admin')->where('gmail', $request->email)->first();
        if ($admin && $request->password === $admin->password) {
            session([
                'admin_id' => $admin->id,
                'ADMIN_LOGIN' => true,
                'admin_verified' => true, // Keep verification flag
            ]);

            if ($request->boolean('remember')) {
                Cookie::queue('email', $request->email, 60 * 24 * 30);
                Cookie::queue('password', $request->password, 60 * 24 * 30);
            } else {
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
            }

            return response()->json([
                'success' => true,
                'message' => 'You have been logged in successfully!',
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Invalid email or password.',
        ], 401);
    }

    public function logout(Request $request)
    {
        // Clear all admin session data including verification
        $request->session()->forget(['admin_id', 'ADMIN_LOGIN', 'admin_verified']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/admin')->with('success', 'Logged out successfully');
    }

     public function dashboard(){
        // Products & Brands
        $result['products'] = DB::table('products')->where(['is_deleted'=>0])->count();
        $result['brands'] = DB::table('brands')->where(['is_deleted'=>0])->count();
        $result['users'] = DB::table('users')->count();
        
        // Orders Statistics
        $result['total_orders'] = DB::table('orders')->count();
        $result['completed_orders'] = DB::table('orders')->where('is_deliverd', 1)->count();
        $result['ongoing_orders'] = DB::table('orders')
            ->where('is_confirm', 1)
            ->where('is_deliverd', '!=', 1)
            ->where('is_cancel', '!=', 1)
            ->count();
        $result['cancelled_orders'] = DB::table('orders')->where('is_cancel', 1)->count();
        $result['pending_orders'] = DB::table('orders')
            ->where('is_confirm', '!=', 1)
            ->where('is_cancel', '!=', 1)
            ->where('is_deliverd', '!=', 1)
            ->count();
        
        // Revenue Calculation
        $result['total_revenue'] = DB::table('orders')
            ->where('is_deliverd', 1)
            ->sum('total_amount');
        
        // Manual Orders
        $result['manual_orders'] = DB::table('manual_orders')->count();
        
        // Recent Orders for Activity
        $result['recent_orders'] = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as customer_name', 'users.email as customer_email')
            ->orderBy('orders.id', 'desc')
            ->limit(5)
            ->get();
        
        // Top Selling Products
        $result['top_products'] = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();
        
        // Sales Data by Order ID (since no timestamp)
        // Weekly Sales - Last 7 orders
        $result['weekly_sales'] = DB::table('orders')
            ->where('is_deliverd', 1)
            ->orderBy('id', 'desc')
            ->limit(7)
            ->get(['id', 'total_amount']);
        
        // Monthly Sales - Last 30 orders
        $result['monthly_sales'] = DB::table('orders')
            ->where('is_deliverd', 1)
            ->orderBy('id', 'desc')
            ->limit(30)
            ->get(['id', 'total_amount']);
        
        // Yearly Sales - Last 365 orders
        $result['yearly_sales'] = DB::table('orders')
            ->where('is_deliverd', 1)
            ->orderBy('id', 'desc')
            ->limit(365)
            ->get(['id', 'total_amount']);
        
        return view('admin.pages.dashboard',$result);
     }
     public function contacts(Request $request){
        $query = DB::table('contacts')->orderBy('id', 'DESC');
        
        // Search filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%')
                  ->orWhere('subject', 'like', '%' . $search . '%');
            });
        }
        
        // Pagination
        $contacts = $query->paginate(10);
        
        // Stats
        $total_queries = DB::table('contacts')->count();
        
        // AJAX request
        if ($request->ajax()) {
            $html = view('admin.pages.partials.contacts-table', compact('contacts'))->render();
            $pagination = view('admin.pages.partials.contacts-pagination', compact('contacts'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination
            ]);
        }
        
        return view('admin.pages.contacts', compact('contacts', 'total_queries'));
     }

     public function pushToShiprocket(Request $request)
     {
         $orderId = $request->input('order_id');
         $order = DB::table('orders')->where('id', $orderId)->first();
         if (!$order) {
             return response()->json(['success' => false, 'message' => 'Order not found.']);
         }
         $orderItems = DB::table('order_items')->where('order_id', $orderId)->get();
         $addresses = DB::table('addresses')->where('id', $orderId)->first();
         if (!$addresses) {
             return response()->json(['success' => false, 'message' => 'Address not found for the order.']);
         }
         DB::table('orders')->where('id', $orderId)->update(['is_confirm'=>1]);
         $data = [
             'order_id' => $order->custom_order_id,
             'order_date' => now()->format('Y-m-d H:i:s'),
             'billing_customer_name' => $addresses->name,
             'billing_last_name' => '',
             'billing_address' => $addresses->address,
             'billing_city' => $addresses->city,
             'billing_pincode' => $addresses->pincode,
             'billing_state' => $addresses->state,
             'billing_country' => 'India',
             'billing_email' => $addresses->email ,
             'billing_phone' => $addresses->phone,
             'shipping_is_billing' => true,
             'order_items' => $orderItems->map(function ($item) {
                 return [
                     'name' => DB::table('products')->where('id', $item->product_id)->value('name'),
                     'sku' => DB::table('products')->where('id', $item->product_id)->value('name') ?? 'N/A',
                     'units' => $item->quantity,
                     'selling_price' => $item->price,
                     'discount' => 0,
                     'tax' => 0,
                     'hsn' => '1',
                 ];
             })->toArray(),
             'payment_method' => $order->payment_method,
             'sub_total' => $order->total_amount,
             'length' => 1,
             'breadth' => 1,
             'height' => 1,
             'weight' => 1,
         ];
         try {
             $apiToken = $this->getShiprocketToken();
             $response = Http::withHeaders([
                 'Authorization' => 'Bearer ' . $apiToken,
             ])->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', $data);

             if ($response->successful()) {
                 return response()->json(['success' => true, 'message' => 'Order pushed successfully.']);
             } else {
                 return response()->json(['success' => false, 'message' => 'Failed to push order.', 'error' => $response->body()]);
             }
         } catch (\Exception $e) {
             return response()->json(['success' => false, 'message' => 'An error occurred while pushing the order.', 'error' => $e->getMessage()]);
         }
     }

     public function maual_order_pushtoshiprocket(Request $request)
     {
         $orderId = $request->input('order_id');
         $order = DB::table('manual_orders')->where('id', $orderId)->first();
         if (!$order) {
             return response()->json(['success' => false, 'message' => 'Order not found.']);
         }

         $data = [
            'order_id' => $order->id,
            'order_date' => now()->format('Y-m-d H:i:s'),
            'billing_customer_name' => $order->name,
            'billing_last_name' => '',
            'billing_address' => $order->street_address,
            'billing_city' => $order->city,
            'billing_pincode' => $order->pincode,
            'billing_state' => $order->state,
            'billing_country' => 'India',
            'billing_email' => $order->email ?? 'not_provided@example.com', // Ensure a valid email is provided
            'billing_phone' => $order->mobile,
            'shipping_is_billing' => true,
            'name' => 'NA',
            'sku' => $order->sku ?? 'default_sku',
            'units' => '1', // Ensure at least 1 unit
            'selling_price' => $order->selling_price ?? '0', // Replace with actual selling price if available
            'discount' => 0,
            'tax' => 0,
            'hsn' => '1',
            'payment_method' => 'COD',
            'sub_total' => 1, // Ensure this is a numeric value
            'length' => 1,
            'breadth' => 1,
            'height' => 1,
            'weight' => 1,
            'order_items' => [ // Added order_items field
                [
                    'name' => $order->product_name ?? 'Product Name', // Ensure this is populated with actual data
                    'sku' => $order->sku ?? 'default_sku',
                    'units' => 1,
                    'selling_price' => $order->selling_price ?? 0,
                    'discount' => 0,
                    'tax' => 0,
                    'hsn' => '1'
                ]
            ]
        ];

        DB::table('manual_orders')->where('id', $orderId)->update(['is_confirm'=>1]);

         try {
             $apiToken = $this->getShiprocketToken();
             $response = Http::withHeaders([
                 'Authorization' => 'Bearer ' . $apiToken,
             ])->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', $data);

             if ($response->successful()) {
                 return response()->json(['success' => true, 'message' => 'Order pushed successfully.']);
             } else {
                 return response()->json(['success' => false, 'message' => 'Failed to push order.', 'error' => $response->body()]);
             }
         } catch (\Exception $e) {
             return response()->json(['success' => false, 'message' => 'An error occurred while pushing the order.', 'error' => $e->getMessage()]);
         }
     }


     private function getShiprocketToken()
     {
         $response = Http::post('https://apiv2.shiprocket.in/v1/external/auth/login', [
             'email' => '734kajaldas@gmail.com',
             'password' => '96798479aA@',
         ]);

         if ($response->successful()) {
             return $response->json()['token'];
         }

         throw new \Exception('Failed to retrieve Shiprocket token.');
     }

     public function settings(){
        $result['settings'] = DB::table('settings')->first();
        return view('admin.pages.settings', $result);
     }

     public function updateSettings(Request $request){
        $request->validate([
            'razorpay_key_id' => 'required|string',
            'razorpay_key_secret' => 'required|string',
        ]);

        $settings = DB::table('settings')->first();

        $data = [
            'razorpay_key_id' => $request->razorpay_key_id,
            'razorpay_key_secret' => $request->razorpay_key_secret,
            'razorpay_enabled' => $request->has('razorpay_enabled') ? 1 : 0,
            'cod_enabled' => $request->has('cod_enabled') ? 1 : 0,
            'google_analytics_id' => $request->google_analytics_id ?? '',
            'google_analytics_api_key' => $request->google_analytics_api_key ?? '',
            'imagekit_public_key' => $request->imagekit_public_key ?? '',
            'imagekit_private_key' => $request->imagekit_private_key ?? '',
            'imagekit_url_endpoint' => $request->imagekit_url_endpoint ?? '',
            'imagekit_enabled' => $request->has('imagekit_enabled') ? 1 : 0,
        ];

        if($settings){
            $data['updated_at'] = now();
            DB::table('settings')->update($data);
        } else {
            $data['created_at'] = now();
            $data['updated_at'] = now();
            DB::table('settings')->insert($data);
        }

        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully!',
        ]);
     }
     
     /**
      * Toggle active/inactive status for categories, subcategories, and collections
      */
     public function toggleStatus(Request $request)
     {
         try {
             $id = $request->input('id');
             $type = $request->input('type');
             $isActive = $request->input('is_active');
             
             // Validate inputs
             if (!$id || !$type || !in_array($isActive, [0, 1])) {
                 return response()->json([
                     'success' => false,
                     'message' => 'Invalid parameters'
                 ], 400);
             }
             
             // Determine table name based on type
             $table = '';
             $itemName = '';
             
             switch ($type) {
                 case 'category':
                     $table = 'categories';
                     $itemName = 'Category';
                     break;
                 case 'subcategory':
                     $table = 'sub_categories';
                     $itemName = 'Subcategory';
                     break;
                 case 'collection':
                     $table = 'collections';
                     $itemName = 'Collection';
                     break;
                 default:
                     return response()->json([
                         'success' => false,
                         'message' => 'Invalid type'
                     ], 400);
             }
             
             // Update status
             $updated = DB::table($table)
                 ->where('id', $id)
                 ->update(['is_active' => $isActive]);
             
             if ($updated) {
                 $status = $isActive == 1 ? 'activated' : 'deactivated';
                 return response()->json([
                     'success' => true,
                     'message' => "{$itemName} {$status} successfully"
                 ]);
             } else {
                 return response()->json([
                     'success' => false,
                     'message' => 'Failed to update status'
                 ], 500);
             }
             
         } catch (\Exception $e) {
             return response()->json([
                 'success' => false,
                 'message' => 'An error occurred: ' . $e->getMessage()
             ], 500);
         }
     }
}

