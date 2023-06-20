<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        try {
            $wishlist = Wishlist::where('user_id', Auth::id())->get();

            return view('frontend.wishlist', compact('wishlist'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong!']);
        }
    }

    public function addProduct(Request $request)
    {
        try {
            if (Auth::check()) {
                if (!Product::find($request->product_id)) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                $wish = new Wishlist();
                $wish->user_id = Auth::id();
                $wish->product_id = $request->product_id;
                $wish->save();

                return response()->json(['status' => 'success', 'message' => 'Product added to wishlist!']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Please login to add product to wishlist!']);
        } catch (\Throwable $th) {
            report ($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

    public function removeProduct(Request $request) {
        try {
            if (Auth::check()) {
                $existingWishlistItem = Wishlist::where('product_id', $request->product_id)->where('user_id', Auth::id())->first();

                if (!$existingWishlistItem) {
                    return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
                }

                $existingWishlistItem->delete();
                return response()->json(['status' => 'success', 'message' => 'Product removed from wishlist!']);
            }

            return response()->json(['status' => 'warning', 'message' => 'Login to Continue!']);
        } catch (\Throwable $th) {
            report ($th);
            return response()->json(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }

    public function wishlistCount()
    {
        try {
            $wishCount = Wishlist::where('user_id', Auth::id())->count();

            return response()->json(['count' => $wishCount]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
