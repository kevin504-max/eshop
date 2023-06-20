<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::where('status', 0)->get();

            return view('admin.order.index', compact('orders'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function view($id)
    {
        try {
            $order = Order::find($id);

            return view('admin.order.view', compact('order'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function update(Request $request) {
        try {
            $order = Order::find($request->id);
            $order->status = $request->order_status;
            $order->save();

            return redirect()->back()->with(['status' => 'success', 'message' => 'Order status updated successfully!']);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function history()
    {
        try {
            $orders = Order::where('status', 1)->get();

            return view('admin.order.history', compact('orders'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }
}
