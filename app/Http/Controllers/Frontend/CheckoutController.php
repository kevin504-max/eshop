<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        try {
            // Obtém todos os itens do carrinho para o usuário autenticado usando SQL puro
            $cartItems = DB::select('SELECT * FROM carts WHERE user_id = ?', [Auth::id()]);

            // Itera sobre os itens do carrinho
            foreach ($cartItems as $item) {
                // Obtém informações do produto usando SQL puro
                $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$item->product_id]);

                // Verifica se o produto existe e se o estoque é menor ou igual à quantidade no carrinho
                if ($product && $product->stock <= $item->items) {
                    // Remove o item do carrinho se o estoque for insuficiente
                    DB::delete('DELETE FROM carts WHERE product_id = ? AND user_id = ?', [$item->product_id, Auth::id()]);
                }
            }

            // Obtém novamente todos os itens do carrinho após as remoções
            $cartItems = DB::select('SELECT * FROM carts WHERE user_id = ?', [Auth::id()]);

            foreach ($cartItems as $cartItem) {
                $cartItem->product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$cartItem->product_id]);
            }

            return view('frontend.checkout', compact('cartItems'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later.'
            ]);
        }
    }


    public function placeOrder(Request $request)
    {
        try {
            $order = new Order();
            $order->user_id = Auth::id();
            $order->username = $request->username;
            $order->email = $request->email;
            $order->phone = $request->phone;
            $order->cpf_cnpj = $request->cpf_cnpj;
            $order->state = $request->state;
            $order->city = $request->city;

            // Calcular o preço total
            $total = 0;
            $cartItems = DB::select('SELECT * FROM carts WHERE user_id = ?', [Auth::id()]);
            foreach ($cartItems as $item) {
                $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$item->product_id]);
                $total += ($product->price - $product->discountPercentage) * $item->items;
            }

            $order->total_price = $total;

            $order->payment_mode = $request->payment_mode;
            $order->payment_id = $request->payment_id;

            $order->tracking_number = 'samambaia' . rand(1111, 9999);
            $order->save();

            foreach ($cartItems as $item) {
                DB::insert('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)', [
                    $order->id,
                    $item->product_id,
                    $item->items,
                    ($product->price - $product->discountPercentage)
                ]);

                $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$item->product_id]);
                DB::update('UPDATE products SET stock = ? WHERE id = ?', [$product->stock - $item->items, $item->product_id]);
            }

            DB::delete('DELETE FROM carts WHERE user_id = ?', [Auth::id()]);

            if ($request->payment_mode == "Paid by Razorpay" || $request->payment_mode == "Paid by Paypal") {
                return response()->json([
                    "status" => "success",
                    "message" => "Order placed successfully!"
                ]);
            }

            return redirect('/my-orders')->with(['status' => 'success', 'message' => 'Order placed successfully!']);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }


    public function razorpayCheck(Request $request)
    {
        try {
            // Obtém os itens do carrinho do banco de dados
            $cartItems = DB::select('SELECT * FROM carts WHERE user_id = ?', [Auth::id()]);

            $total_price = 0;

            // Calcula o preço total
            foreach ($cartItems as $item) {
                $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$item->product_id]);
                $total_price += (($product->price - $product->discountPercentage) * $item->items);
            }

            $username = $request->input('username');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $cpf_cnpj = $request->input('cpf_cnpj');
            $state = $request->input('state');
            $city = $request->input('city');

            return response()->json([
                "username" => $username,
                "email" => $email,
                "phone" => $phone,
                "cpf_cnpj" => $cpf_cnpj,
                "state" => $state,
                "city" => $city,
                "total_price" => $total_price
            ]);
        } catch (\Throwable $th) {
            report($th);
            return response()->json([
                "status" => "error",
                "message" => "Something went wrong! Try again."
            ]);
        }
    }
}
