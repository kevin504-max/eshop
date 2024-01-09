<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
    {
        try {
            $wishlist = DB::select("
                SELECT w.*, p.*
                FROM wishlists w
                JOIN products p ON w.product_id = p.id
                WHERE w.user_id = ?
            ", [Auth::id()]);

            // Atribui os produtos aos itens do pedido
            foreach ($wishlist as $item) {
                $item->product = DB::selectOne("
                    SELECT *
                    FROM products
                    WHERE id = ?
                ", [$item->product_id]);
            }

            return view('frontend.wishlist', compact('wishlist'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }


    public function addProduct(Request $request)
    {
        try {
            if (Auth::check()) {
                $productId = $request->product_id;

                // Verifica se o produto existe
                $productExists = DB::table('products')->where('id', $productId)->exists();

                if (!$productExists) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                // Verifica se o produto já está na lista de desejos do usuário
                $wishlistExists = DB::table('wishlists')
                    ->where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->exists();

                if ($wishlistExists) {
                    return response()->json(['status' => 'info', 'message' => 'Product is already in your wishlist.']);
                }

                // Adiciona o produto à lista de desejos
                DB::table('wishlists')->insert([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return response()->json(['status' => 'success', 'message' => 'Product added to wishlist!']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Please login to add a product to the wishlist!']);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

    public function removeProduct(Request $request)
    {
        try {
            if (Auth::check()) {
                $productId = $request->product_id;

                // Verifica se o produto está na lista de desejos do usuário
                $wishlistItem = DB::table('wishlists')
                    ->where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

                if (!$wishlistItem) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                // Remove o produto da lista de desejos
                DB::table('wishlists')
                    ->where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->delete();

                return response()->json(['status' => 'success', 'message' => 'Product removed from wishlist!']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

    public function wishlistCount()
    {
        try {
            $wishCount = DB::table('wishlists')->where('user_id', Auth::id())->count();

            return response()->json(['count' => $wishCount]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
