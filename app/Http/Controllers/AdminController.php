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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = DB::table('admin')->where('gmail', $request->email)->first();
        if ($admin && $request->password === $admin->password) {
            session([
                'admin_id' => $admin->id,
                'ADMIN_LOGIN' => true,
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

     public function dashboard(){
        $result['products'] = DB::table('products')->where(['is_deleted'=>0])->count();
        $result['brands'] = DB::table('brands')->where(['is_deleted'=>0])->count();
        $result['users'] = DB::table('users')->count();
        return view('admin.pages.dashboard',$result);
     }
     public function contacts(){
        $result['contacts'] = DB::table('contacts')->get();
        return view('admin.pages.contacts',$result);
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

        if($settings){
            DB::table('settings')->update([
                'razorpay_key_id' => $request->razorpay_key_id,
                'razorpay_key_secret' => $request->razorpay_key_secret,
                'razorpay_enabled' => $request->has('razorpay_enabled') ? 1 : 0,
                'updated_at' => now(),
            ]);
        } else {
            DB::table('settings')->insert([
                'razorpay_key_id' => $request->razorpay_key_id,
                'razorpay_key_secret' => $request->razorpay_key_secret,
                'razorpay_enabled' => $request->has('razorpay_enabled') ? 1 : 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Razorpay settings updated successfully!',
        ]);
     }
}

