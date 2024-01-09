<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function rate(Request $request)
    {
        try {
            $productId = $request->input('product_id');
            $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$productId]);

            if (!$product) {
                return redirect()->back()->with(['status' => 'error', 'message' => 'The link you followed was broken.']);
            }

            $verifiedPurchase = DB::selectOne(
                'SELECT * FROM orders
                JOIN order_items ON orders.id = order_items.order_id
                WHERE orders.user_id = ?
                AND order_items.product_id = ?', [Auth::id(), $productId]
            );

            if (!$verifiedPurchase) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'You cannot rate a product without purchase.']);
            }

            DB::statement("
                    INSERT INTO ratings (user_id, product_id, rating, created_at, updated_at)
                    VALUES (?, ?, ?, NOW(), NOW())
                    ON DUPLICATE KEY UPDATE rating = VALUES(rating), updated_at = NOW()
                ", [Auth::id(), $productId, $request->input('product_rating')]
            );

            return redirect()->back()->with(['status' => 'success', 'message' => 'Thank you for your rating!']);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

}
