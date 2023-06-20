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
                $product = Product::find($request->product_id);

                if (!$product) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                $existingCartItem = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();

                if ($existingCartItem) {
                    return response()->json(['status' => 'info', 'message' => $product->title . " Already Added to cart."]);
                }

                $cartItem = new Cart();
                $cartItem->user_id = Auth::id();
                $cartItem->product_id = $request->product_id;
                $cartItem->items = $request->quantity;
                $cartItem->save();

                return response()->json(['status' => 'success', 'message' => $product->title . ' Added to cart!']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report ($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

    public function viewCart() {
        $cartItems = Cart::where('user_id', Auth::id())->get();

        return view('frontend.cart', compact('cartItems'));
    }

    public function updateCart(Request $request) {
        try {
            if (Auth::check()) {
                if (Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->exists()) {
                    $cart = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();
                    $cart->items = $request->quantity;
                    $cart->update();

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

    public function removeProduct(Request $request) {
        try {
            if (Auth::check()) {
                $existingCartItem = Cart::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();

                if (!$existingCartItem) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                $existingCartItem->delete();
                return response()->json(['status' => 'success', 'message' => 'Product removed from cart!']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report ($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }
}
