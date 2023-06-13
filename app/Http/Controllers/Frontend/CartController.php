<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function addProduct(Request $request) {
        try {
            if (Auth::check()) {
                $product = Product::findOrFail($request->product_id);

                if (!$product) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                if (Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->exists()) {
                    return response()->json(['status' => 'error', 'message' => $product->title . " Already Added to cart."]);
                }

                $cartItem = new Cart();
                $cartItem->user_id = Auth::id();
                $cartItem->product_id = $request->product_id;
                $cartItem->items = $request->quantity;
                $cartItem->save();

                return response()->json(['status' => 'success', 'message' => $product->title . ' Added to cart!']);
            }

            return response()->json(['status' => 'error', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report ($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }
}
