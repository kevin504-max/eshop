<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FrontEndController extends Controller
{
    public function index()
    {
        try {
            // Consulta para obter os 3 produtos com maior desconto
            $featureds = DB::select('SELECT * FROM products ORDER BY discountPercentage DESC LIMIT 3');

            // Consulta para obter todos os produtos ordenados por classificação (rating) decrescente
            $most_rated = DB::select('SELECT * FROM products ORDER BY rating DESC');

            // Consulta para obter as categorias populares
            $popular_categories = DB::select('SELECT * FROM categories WHERE popular = 1');

            return view('frontend.index', compact('featureds', 'most_rated', 'popular_categories'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }


    public function category()
    {
        try {
            // Consulta para obter as categorias com status igual a 1
            $categories = DB::select('SELECT * FROM categories WHERE status = 1');

            return view('frontend.category', compact('categories'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }

    public function viewCategory($slug)
    {
        try {
            // Consulta para verificar se a categoria com o slug fornecido existe
            $categoryExists = DB::selectOne('SELECT * FROM categories WHERE slug = ?', [$slug]);

            if ($categoryExists) {
                // Consulta para obter a categoria com base no slug
                $category = DB::selectOne('SELECT * FROM categories WHERE slug = ?', [$slug]);

                // Consulta para obter os produtos da categoria
                $products = DB::select('SELECT * FROM products WHERE category_id = ?', [$category->id]);

                return view('frontend.products.index', compact('category', 'products'));
            }

            return redirect('/')->with('error', 'Slug does not match any category.');
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }

    public function viewProduct($category_slug, $product_slug)
    {
        try {
            // Consulta para obter a categoria com base no slug
            $category = DB::selectOne('SELECT * FROM categories WHERE slug = ?', [$category_slug]);

            if (!$category) {
                return redirect('/')->with('error', 'No such category found...');
            }

            // Consulta para obter o produto com base no slug e na categoria
            $product = DB::selectOne('SELECT * FROM products WHERE slug = ? AND category_id = ?', [$product_slug, $category->id]);

            $product->category = $category;

            if (!$product) {
                return redirect('/')->with('error', 'The link was broken.');
            }

            // Consulta para obter as avaliações do produto
            $ratings = DB::select('SELECT * FROM ratings WHERE product_id = ?', [$product->id]);

            // Consultas para calcular a soma e a média das avaliações
            $ratings_sum = DB::selectOne('SELECT SUM(rating) as sum FROM ratings WHERE product_id = ?', [$product->id])->sum;
            $ratings_count = count($ratings);
            $ratings_value = ($ratings_count > 0) ? $ratings_sum / $ratings_count : 0;

            // Consulta para obter a avaliação do usuário atual
            $user_rating = DB::selectOne('SELECT * FROM ratings WHERE product_id = ? AND user_id = ?', [$product->id, Auth::id()]);

            // Consulta para obter as análises do produto
            $reviews = DB::select('SELECT * FROM reviews WHERE product_id = ?', [$product->id]);

            return view('frontend.products.view', compact('category', 'product', 'ratings', 'ratings_value', 'user_rating', 'reviews'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with('error', 'Something went wrong! Try again.');
        }
    }

    public function productListAjax()
    {
        try {
            $products = DB::select('SELECT title FROM products');
            $data = [];

            foreach ($products as $product) {
                $data[] = $product->title;
            }

            return response()->json($data);
        } catch (\Throwable $th) {
            report($th);
            return response()->json(['error' => 'Something went wrong!']);
        }
    }

    public function searchProduct(Request $request)
    {
        try {
            $searched_product = $request->search_product;

            if (!$searched_product) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'Please enter a product name to search.']);
            }

            $products = DB::select('SELECT * FROM products WHERE title LIKE ?', ['%' . $searched_product . '%']);

            if (count($products) == 0) {
                return redirect()->back()->with(['status' => 'info', 'message' => 'No products matched your search.']);
            }

            // Atribui a categoria de cada produto
            foreach ($products as $product) {
                $product->category = DB::selectOne('SELECT * FROM categories WHERE id = ?', [$product->category_id]);
            }

            return redirect('category/' . $products[0]->category->slug . '/' . $products[0]->slug);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(['status' => 'error', 'message' => 'Something went wrong! Try again.']);
        }
    }
}
