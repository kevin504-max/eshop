<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function rate(Request $request)
    {
        try {
            $product_check = Product::find($request->input('product_id'));

            if (!$product_check) {
                return redirect()->back()->with(['status' => 'error', 'message' => 'The link you followed was broken.']);
            }

            $verified_purchase = Order::where('orders.user_id', Auth::id())
                ->join('order_items', 'orders.id', 'order_items.order_id')
                ->where('order_items.product_id', $product_check->id)->get();

            if (!$verified_purchase->count()) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'You cannot rate a product without purchase.']);
            }

            $existing_rating = Rating::where('user_id', Auth::id())->where('product_id', $request->input('product_id'))->first();

            if (!$existing_rating) {
                $data = [
                    'user_id' => Auth::id(),
                    'product_id' => $request->input('product_id'),
                    'rating' => $request->input('product_rating')
                ];

                Rating::create($data);
            } else {
                $existing_rating->rating = $request->input('product_rating');
                $existing_rating->update();
            }

            return redirect()->back()->with(['status' => 'success', 'message' => 'Thank you for your rating!']);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }
}
