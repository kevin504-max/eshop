<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $orders = DB::select("
            SELECT *
            FROM orders
            WHERE user_id = ?
        ", [Auth::id()]);

        return view('frontend.orders.index', compact('orders'));
    }

    public function view($id)
    {
        $order = DB::select("
            SELECT *
            FROM orders
            WHERE id = ? AND user_id = ?
        ", [$id, Auth::id()]);

        $order = (!empty($order)) ? $order[0] : null;

        // Atribui os itens do pedido
        $order->orderItems = DB::select("
            SELECT *
            FROM order_items
            WHERE order_id = ?
        ", [$id]);

        // Atribui os produtos aos itens do pedido
        foreach ($order->orderItems as $item) {
            $item->product = DB::selectOne("
                SELECT *
                FROM products
                WHERE id = ?
            ", [$item->product_id]);
        }

        return view('frontend.orders.view', compact('order'));
    }
}
