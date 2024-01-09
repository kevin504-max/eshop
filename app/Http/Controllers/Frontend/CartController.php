<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addProduct(Request $request)
    {
        try {
            if (Auth::check()) {
                $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$request->product_id]);

                if (!$product) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                $existingCartItem = DB::selectOne('SELECT * FROM carts WHERE product_id = ? AND user_id = ?', [$request->product_id, Auth::id()]);

                if ($existingCartItem) {
                    return response()->json(['status' => 'info', 'message' => $product->title . " Already Added to cart."]);
                }

                // Inserção de novo item no carrinho usando SQL puro
                DB::insert('INSERT INTO carts (user_id, product_id, items) VALUES (?, ?, ?)', [Auth::id(), $request->product_id, $request->quantity]);

                return response()->json(['status' => 'success', 'message' => $product->title . ' Added to cart!']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }


    public function viewCart()
    {
        try {
            // Seleciona os itens do carrinho para o usuário autenticado usando SQL puro
            $cartItems = DB::select('SELECT * FROM carts WHERE user_id = ?', [Auth::id()]);

            // Atribui o produto de cada item do carrinho
            foreach ($cartItems as $cartItem) {
                $cartItem->product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$cartItem->product_id]);
            }

            return view('frontend.cart', compact('cartItems'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }


    public function updateCart(Request $request)
    {
        try {
            if (Auth::check()) {
                // Verifica se o item do carrinho existe
                $cartExists = DB::selectOne('SELECT * FROM carts WHERE product_id = ? AND user_id = ?', [$request->product_id, Auth::id()]);

                if ($cartExists) {
                    // Atualiza a quantidade do item no carrinho usando SQL puro
                    DB::update('UPDATE carts SET items = ? WHERE product_id = ? AND user_id = ?', [$request->quantity, $request->product_id, Auth::id()]);

                    return response()->json(['status' => 'success', 'message' => 'Cart Updated!']);
                }

                return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

    public function removeProduct(Request $request)
    {
        try {
            if (Auth::check()) {
                // Verifica se o item do carrinho existe
                $existingCartItem = DB::selectOne('SELECT * FROM carts WHERE product_id = ? AND user_id = ?', [$request->product_id, Auth::id()]);

                if ($existingCartItem) {
                    // Remove o item do carrinho usando SQL puro
                    DB::delete('DELETE FROM carts WHERE product_id = ? AND user_id = ?', [$request->product_id, Auth::id()]);

                    return response()->json(['status' => 'success', 'message' => 'Product removed from cart!']);
                }

                return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

    public function cartCount()
    {
        try {
            // Conta o número de itens no carrinho para o usuário autenticado usando SQL puro
            $cartCount = DB::selectOne('SELECT COUNT(*) as count FROM carts WHERE user_id = ?', [Auth::id()])->count;

            return response()->json(['count' => $cartCount]);
        } catch (\Throwable $th) {
            report($th);
        }
    }
}
