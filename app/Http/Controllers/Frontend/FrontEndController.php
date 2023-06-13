<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

    public function viewProduct($category_slug, $product_title) {
        try {
            $category = Category::where('slug', $category_slug)->first();

            if (!isset($category)) {
                return redirect('/')->with('error', 'No such category found...');
            }

            $product = Product::where('title', $product_title)->first();

            if (!$product) {
                return redirect('/')->with('error', 'The link was broken.');
            }

            return view('frontend.products.view', compact('category', 'product'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }
    // test function
    public function productCategory() {
        $products = Product::all();

        foreach ($products as $product) {
            $product->category_id = rand(121, 130);
            $product->save();
        }
    }
    // test function
    public function createCategories() {
        for ($i = 0; $i < 10; $i++) {

            $datas = [
                "name" => "Category " . $i,
                "slug" => "category_" . $i,
                "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
                "status" => rand(0, 1),
                "popular" => rand(0, 1),
                "image" => "https://picsum.photos/id/" . rand(1, 100) . "/200/300",
                "meta_title" => "Category " . $i,
                "meta_description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
                "meta_keywords" => "Category " . $i
            ];

            Category::create($datas);
        }
    }
}
