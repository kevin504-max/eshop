<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index() {
        $featureds = Product::orderBy("discountPercentage", "desc")->take(3)->get();
        $most_rated = Product::orderBy("rating", "desc")->get();

        return view('frontend.index', compact('featureds', 'most_rated'));
    }
}
