<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        try {
            $cartItems = Cart::where('user_id', Auth::id())->get();

            foreach ($cartItems as $item) {
                $product = Product::where('id', $item->product_id)->first();

                if (isset($product) && ($product->stock <= $item->quantity)) {
                    $item->delete();
                }
            }

            $cartItems = Cart::where('user_id', Auth::id())->get();

            return view('frontend.checkout', compact('cartItems'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->json([
                'status' => 'error',
                'message' => 'Something went wrong! Please try again later.'
            ]);
        }
    }
}
