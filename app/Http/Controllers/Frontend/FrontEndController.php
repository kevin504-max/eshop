<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index() {
        $highlights = Product::orderBy("discountPercentage", "desc")->take(3)->get();

        return view('frontend.index', compact('highlights'));
    }
}
