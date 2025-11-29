<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),

            new Middleware('permission:order view', only: ['index']),
            new Middleware('permission:order button view', only: ['updateOrderStatus']),
            new Middleware('permission:order status create', only: ['updateOrderStatus']),
            new Middleware('permission:order status view', only: ['updateOrderStatus']),



            new Middleware('permission:order edit', only: ['edit', 'update']),
            new Middleware('permission:order delete', only: ['destroy']),
        ];
    }
    public function index()
    {
        $orders = Order::all();

        return view('admin.order.vieworder', compact('orders'));
    }

    // update status and email send

    public function updateOrderStatus($order_id, $status)
    {
        $order = Order::find($order_id); // fetch the model

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $order->order_status = $status;
        $order->save();
        $productItems = json_decode($order->product_items, true);

        Mail::to($order->order_email)->queue(new OrderStatusUpdated($order, $status, $productItems));

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }

    // destroy function

    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order not found.');
        }

        $order->delete();

        return response()->json(['message' => 'order deleted successfully.']);
    }
}
