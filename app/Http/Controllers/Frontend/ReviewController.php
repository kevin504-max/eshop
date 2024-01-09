<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function create($product_slug)
    {
        try {
            $product = DB::table('products')
                ->where('slug', $product_slug)
                ->first();

            if (!$product) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
            }

            $userId = Auth::id();

            // Check if the user has already reviewed the product
            $review = DB::table('reviews')
                ->where('user_id', $userId)
                ->where('product_id', $product->id)
                ->first();

            // Atribui o produto ao comentário
            $review->product = $product;

            if ($review) {
                return view('frontend.reviews.edit', compact('review'));
            }

            // Check if the user has purchased the product
            $verifiedPurchase = DB::table('orders')
                ->join('order_items', 'orders.id', 'order_items.order_id')
                ->where('orders.user_id', $userId)
                ->where('order_items.product_id', $product->id)
                ->get();

            if (!$verifiedPurchase->count()) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'You can only review products you have purchased!']);
            }

            return view('frontend.reviews.index', compact('product', 'verifiedPurchase'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }


    public function store(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $userId = Auth::id();

            // Check if the product exists
            $product = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.slug as category_slug')
                ->where('products.id', $productId)
                ->first();

            if (!$product) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
            }

            $userReview = $request->input('user_review');

            // Insert the new review
            $newReviewId = DB::table('reviews')->insertGetId([
                'user_id' => $userId,
                'product_id' => $productId,
                'review' => $userReview,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($newReviewId) {
                return redirect('category/' . $product->category_slug . '/' . $product->slug)
                    ->with(['status' => 'success', 'message' => 'Review added successfully!']);
            }
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function edit($product_slug)
    {
        $product = DB::select("SELECT * FROM products WHERE slug = ?", [$product_slug]);

        if (empty($product)) {
            return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
        }

        $review = DB::select("
            SELECT * FROM reviews
            WHERE user_id = ? AND product_id = ?
            LIMIT 1
        ", [Auth::id(), $product[0]->id]);

        if (empty($review)) {
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

        $review = DB::select("
            SELECT reviews.id AS id
            FROM reviews
            INNER JOIN products ON reviews.product_id = products.id
            WHERE reviews.user_id = ? AND reviews.id = ?
            LIMIT 1
        ", [Auth::id(), $request->input('review_id')]);

        if (empty($review)) {
            return redirect()->back()->with(['status' => 'info', 'message' => 'The link you followed was broken!']);
        }

        DB::update("
            UPDATE reviews
            SET review = ?
            WHERE id = ?
        ", [$request->input('user_review'), $review[0]->id]);

        // Atribui o slug da categoria e do produto ao comentário
        $review[0]->category_slug = $request->input('category_slug');
        $review[0]->product_slug = $request->input('product_slug');

        return redirect('category/' . $review[0]->category_slug . '/' . $review[0]->product_slug)->with(['status' => 'success', 'message' => 'Review updated successfully!']);
    }
}
