<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index() {
        $featureds = Product::orderBy("discountPercentage", "desc")->take(3)->get();
        $most_rated = Product::orderBy("rating", "desc")->get();
        $popular_categories = Category::where('popular', 1)->get();

        return view('frontend.index', compact('featureds', 'most_rated', 'popular_categories'));
    }

    public function category() {
        $categories = Category::where('status', 0)->get();
        return view('frontend.category', compact('categories'));
    }

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
