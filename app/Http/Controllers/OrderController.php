<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TrackingDetailsMail;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
        ->orderBy('order_id','DESC')
        ->get();

        return view('admin.pages.orders.manualorder',$result);
    }
    public function ManualOngoingOrder(){

        $result['orders'] = DB::table('manual_orders')
        ->where(['is_deleted'=>0])
        ->where('is_confirm','!=',1)
        ->where('is_proceed','=',1)
        ->orderBy('order_id','DESC')
        ->get();

        return view('admin.pages.orders.manual_ongoing',$result);
    }
    public function ShippedOrder(){

        $result['orders'] = DB::table('manual_orders')
        ->where(['is_deleted'=>0])
        ->where('is_confirm',1)
        ->orderBy('id','DESC')
        ->get();

        return view('admin.pages.orders.shippedorder',$result);
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



    public function storeTrackingDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:manual_orders,id',
            'tracking_id' => 'required|string|max:255',
            'tracking_link' => 'required|url',
            // 'tracking_slip' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = DB::table('manual_orders')->where('id', $request->order_id)->first();

        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $trackingSlipPath = null;
        if ($request->hasFile('tracking_slip')) {
            $file = $request->file('tracking_slip');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/manualorders/slip'), $filename);
            $trackingSlipPath = url('public/uploads/manualorders/slip/' . $filename);
        }

        DB::table('manual_orders')->where('id', $request->order_id)->update([
            'tracking_id' => $request->tracking_id,
            'tracking_link' => $request->tracking_link,
            'tracking_slip' => $trackingSlipPath,
        ]);

        $customerEmail = $order->email;

        if ($customerEmail) {
            Mail::to($customerEmail)->send(new TrackingDetailsMail($order, $request->tracking_id, $request->tracking_link, $trackingSlipPath));
        }

        return response()->json(['success' => 'Tracking details updated and email sent successfully!']);
    }


    public function viewTrackingDetails(Request $request)
{
    $order = DB::table('manual_orders')->where('id', $request->order_id)->first();

    if (!$order) {
        return response()->json(['success' => false, 'message' => 'Order not found'], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'tracking_id' => $order->tracking_id ?? 'Not Available',
            'tracking_link' => $order->tracking_link ?? '#',
            'tracking_slip' => $order->tracking_slip ? asset($order->tracking_slip) : null,
        ]
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
public function updateProceedStatus(Request $request)
{
    $orderId = $request->order_id;


    $update = DB::table('manual_orders')->where('id', $orderId)->update(['is_proceed' => 1]);

    if ($update) {
        return response()->json(['status' => 'success', 'message' => 'Order marked as Proceeded!']);
    } else {
        return response()->json(['status' => 'error', 'message' => 'Failed to update order!']);
    }
}
public function manualdestroy($id)
{
    $category = DB::table('manual_orders')->where('id',$id)->first();
    if ($category) {
        DB::table('manual_orders')->where('id',$id)->update(['is_deleted'=>1]);
        return response()->json(['success' => true, 'message' => 'Order deleted successfully.']);
    }

    return response()->json(['success' => false, 'message' => 'Order not found.']);
}
public function updateConfirmStatus(Request $request)
{
    $orderId = $request->order_id;

    $update = DB::table('orders')->where('id', $orderId)->update(['is_confirm' => 1]);

    if ($update) {
        return response()->json(['status' => 'success', 'message' => 'Order marked as Shipped!']);
    } else {
        return response()->json(['status' => 'error', 'message' => 'Failed to update order!']);
    }
}



}
