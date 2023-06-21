<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontEndController extends Controller
{
    public function index() {
        try {
            $featureds = Product::orderBy("discountPercentage", "desc")->take(3)->get();
            $most_rated = Product::orderBy("rating", "desc")->get();
            $popular_categories = Category::where('popular', 1)->get();

            return view('frontend.index', compact('featureds', 'most_rated', 'popular_categories'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }

    public function category() {
        try {
            $categories = Category::where('status', 0)->get();
            return view('frontend.category', compact('categories'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }

    public function viewCategory($slug) {
        try {
            if (Category::where('slug', $slug)->exists()) {
                $category = Category::where('slug', $slug)->first();
                $products = Product::where('category_id', $category->id)->get();

                return view('frontend.products.index', compact('category', 'products'));
            }

            return redirect('/')->with('error', 'Slug does not match any category.');
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }

    public function viewProduct($category_slug, $product_slug) {
        try {
            $category = Category::where('slug', $category_slug)->first();

            if (!isset($category)) {
                return redirect('/')->with('error', 'No such category found...');
            }

            $product = Product::where('slug', $product_slug)->first();

            if (!$product) {
                return redirect('/')->with('error', 'The link was broken.');
            }

            $ratings = Rating::where('product_id', $product->id)->get();
            $ratings_sum = Rating::where('product_id', $product->id)->sum('rating');
            $ratings_value = ($ratings->count() > 0) ? $ratings_sum / $ratings->count() : 0;
            $user_rating = Rating::where('product_id', $product->id)->where('user_id', Auth::id())->first();
            $reviews = Review::where('product_id', $product->id)->get();

            return view('frontend.products.view', compact('category', 'product', 'ratings', 'ratings_value', 'user_rating', 'reviews'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }

    // TEST FUNCTION
    public function createCategories() {
        $categories = Product::pluck('category')->unique();

        foreach($categories as $category) {
            $data = [
                "name" => $category,
                "slug" => Str::slug($category, '_'),
                "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
                "status" => rand(0, 1),
                "popular" => rand(0, 1),
                "image" => "https://picsum.photos/id/" . rand(1, 100) . "/200/300",
                "meta_title" => "Category ",
                "meta_description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
                "meta_keywords" => "Category"
            ];

            Category::create($data);
        }
        $products = Product::all();

        foreach($products as $product) {
            $product->category_id = Category::where('name', $product->category)->first()->id;
            $product->save();
        }

    }

    public function productListAjax()
    {
        $products = Product::select('title')->get();
        $data = [];

        foreach ($products as $product) {
            $data[] = $product['title'];
        }

        return $data;
    }

    public function searchProduct(Request $request)
    {
        try {
            $searched_product = $request->search_product;

            if (!$searched_product) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'Please enter a product name to search.']);
            }

            $product = Product::where("title", "LIKE", "%$searched_product%")->with('hasCategory')->first();

            if (!$product) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'No products matched your search.']);
            }

            return redirect('category/' . $product->hasCategory->slug . '/' . $product->slug);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }
}
