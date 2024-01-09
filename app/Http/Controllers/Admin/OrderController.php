<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        try {
            // Seleciona pedidos com status 0, ordenados por data de criação em ordem decrescente
            $orders = DB::select('SELECT * FROM orders WHERE status = ? ORDER BY created_at DESC', [0]);

            return view('admin.order.index', compact('orders'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }


    public function view($id)
    {
        try {
            // Seleciona o pedido com base no ID
            $order = DB::selectOne('SELECT * FROM orders WHERE id = ?', [$id]);

            if (!$order) {
                return redirect()->back()->with(['status' => 'error', 'message' => 'Order not found!']);
            }

            // Atribui os itens do pedido
            $order->orderItems = DB::select('SELECT * FROM order_items WHERE order_id = ?', [$id]);

            // Atribui os produtos aos itens do pedido
            foreach ($order->orderItems as $item) {
                $item->product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$item->product_id]);
            }

            return view('admin.order.view', compact('order'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }


    public function update(Request $request)
    {
        try {
            // Atualiza o status do pedido usando SQL puro
            DB::update('UPDATE orders SET status = ? WHERE id = ?', [$request->order_status, $request->id]);

            return redirect()->back()->with(['status' => 'success', 'message' => 'Order status updated successfully!']);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }


    public function history()
    {
        try {
            // Seleciona pedidos com status 1 (histórico de pedidos)
            $orders = DB::select('SELECT * FROM orders WHERE status = ?', [1]);

            return view('admin.order.history', compact('orders'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }
}
