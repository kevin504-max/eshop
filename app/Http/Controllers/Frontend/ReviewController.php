<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($product_slug)
    {
        try {
            $product = Product::where('slug', $product_slug)->first();

            if (!$product) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
            }

            $review = Review::where('user_id', Auth::id())->where('product_id', $product->id)->first();

            if ($review) {
                return view('frontend.reviews.edit', compact('review'));
            }

            $verified_purchase = Order::where('orders.user_id', Auth::id())
                ->join('order_items', 'orders.id', 'order_items.order_id')
                ->where('order_items.product_id', $product->id)->get();

            if (!$verified_purchase->count()) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'You can only review products you have purchased!']);
            }

            return view('frontend.reviews.index', compact('product', 'verified_purchase'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function store(Request $request)
    {
        try {
            $product = Product::with('category')->find($request->input('product_id'));

            if (!$product) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
            }

            $user_review = $request->input('user_review');

            $data = [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'review' => $user_review
            ];

            $new_review = Review::create($data);

            if ($new_review) {
                return redirect('category/' . $product->category->slug . '/' . $product->slug)->with(['status' => 'success', 'message' => 'Review added successfully!']);
            }
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function edit($product_slug)
    {
        $product = Product::where('slug', $product_slug)->first();

        if (!$product) {
            return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
        }

        $review = Review::where('user_id', Auth::id())->where('product_id', $product->id)->first();

        if (!$review) {
            return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
        }

        return view('frontend.reviews.edit', compact('review'));
    }

    public function update(Request $request)
    {
        $user_review = $request->input('user_review');

        if ($user_review == '') {
            return redirect()->back()->with(['status' => 'info', 'message' => 'You cannot submit an empty review!']);
        }

        $review = Review::where('user_id', Auth::id())->where('id', $request->input('review_id'))->first();

        if (!$review) {
            return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
        }

        $review->review = $request->input('user_review');
        $review->update();

        return redirect('category/' . $review->product->category->slug . '/' . $review->product->slug)->with(['status' => 'success', 'message' => 'Review updated successfully!']);
    }
}
