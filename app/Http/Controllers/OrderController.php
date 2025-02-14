<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function latestOrder(){
        $result['orders'] = DB::table('orders')->where('is_confirm', '!=', 1)->where('is_cancel', '!=', 1)
        ->where('is_deliverd', '!=', 1)
        ->orderBy('id','DESC')
        ->get();
        return view('admin.pages.orders.latest',$result);
    }
    public function OngoingOrder(){
        $result['orders'] = DB::table('orders')
    ->where('is_confirm', 1)
    ->where('is_deliverd', '!=', 1)
    ->orderBy('id','DESC')
    ->get();


        return view('admin.pages.orders.ongoingorder',$result);
    }
    public function CancelOrder(){
        $result['orders'] = DB::table('orders')
    ->where('is_cancel', 1)
    ->where('is_deliverd', '!=', 1)
    ->where('is_confirm', '!=', 1)
    ->orderBy('id','DESC')
    ->get();


        return view('admin.pages.orders.cancelorder',$result);
    }
    public function ManualOrder(){

        $result['orders'] = DB::table('manual_orders')
        ->where(['is_deleted'=>0])
        ->where('is_confirm','!=',1)
        ->orderBy('id','DESC')
        ->get();

        return view('admin.pages.orders.manualorder',$result);
    }
    public function DeliveredOrder(){
        $result['orders'] = DB::table('orders')->where(['is_deliverd'=>1])->get();

        return view('admin.pages.orders.deliveredorder',$result);
    }
    public function latestOrderView($custom_order_id)
    {
        // Fetch order details
        $order = DB::table('orders')->where('custom_order_id', $custom_order_id)->first();

        if (!$order) {
            abort(404, 'Order not found');
        }

        // Fetch order items with product details
        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select(
                'order_items.*',
                'products.name as product_name',
                'products.slug',
                'order_items.product_id',

            )
            ->where('order_items.order_id', $order->id)
            ->get();

        return view('admin.pages.orders.view', [
            'order' => $order,
            'order_items' => $orderItems,
        ]);
    }


      public function updateOrderStatus($orderId, Request $request)
{
    try {
        // Fetch the order using DB query
        $order = DB::table('orders')->where('id', $orderId)->first();

        // Check if the order exists
        if ($order) {
            // Update the order status to 'delivered'
            $update = DB::table('orders')->where('id', $orderId)->update(['is_deliverd' => 1]);

            if ($update) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => 'Failed to update order status']);
            }
        }

        return response()->json(['success' => false, 'error' => 'Order not found']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}
public function updateOrderCancelStatus($orderId, Request $request)
{
    try {
        // Fetch the order using DB query
        $order = DB::table('orders')->where('id', $orderId)->first();

        // Check if the order exists
        if ($order) {
            // Update the order status to 'cancelled'
            $update = DB::table('orders')->where('id', $orderId)->update(['is_cancel' => 1]);

            if ($update) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'error' => 'Failed to update order status']);
            }
        }

        return response()->json(['success' => false, 'error' => 'Order not found']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()]);
    }
}




}
