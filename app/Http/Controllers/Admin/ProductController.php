<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $directory = "assets/uploads/product/";
    public function index() {
        try {
            $query = DB::select('SELECT * FROM products');

            // Converter os objetos Product para arrays
            $products = array_map(function ($product) {
                $product->category = DB::select('SELECT * FROM categories WHERE id = ?', [$product->category_id])[0];

                return (array) $product;
            }, $query);

            $categories = DB::select('SELECT * FROM categories WHERE status = ?', [1]);

            return view('admin.product.index', compact('products', 'categories'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function store(Request $request) {
        try {
            $price = str_replace(",", ".", $request->price);
            $price = str_replace(".", "", $price) / 100;
            $discount = str_replace(",", ".", $request->discount);
            $discount = str_replace(".", "", $discount) / 100;

            // Manipulação de arquivo
            $thumbnail = null;
            if ($request->hasFile("thumbnail")) {
                $file = $request->file("thumbnail");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move($this->directory, $filename);
                $thumbnail = $filename;
            }

            // Inserção de dados usando SQL puro
            DB::insert('INSERT INTO products (title, slug, category_id, description, price, discountPercentage, rating, stock, brand, thumbnail, created_at, updated_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', [
                            $request->name,
                            Str::slug($request->name, "_"),
                            $request->category_id,
                            $request->description,
                            $price,
                            $discount,
                            0,
                            $request->stock,
                            $request->brand,
                            $thumbnail,
                            now(),
                            now(),
                        ]);

            return redirect()->back()->with(["status" => "success", "message" => "Product registered successfully!"]);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function update(Request $request) {
        try {
            $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$request->id]);

            if (!$product) {
                return redirect()->back()->with(["status" => "error", "message" => "Product not found!"]);
            }

            if ($request->hasFile("thumbnail")) {
                $path = $this->directory . $product->thumbnail;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file("thumbnail");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move($this->directory, $filename);
                $product->thumbnail = $filename;
            }

            $price = str_replace(",", ".", $request->price);
            $price = str_replace(".", "", $price) / 100;
            $discount = str_replace(",", ".", $request->discount);
            $discount = str_replace(".", "", $discount) / 100;

            // Atualização de dados usando SQL puro
            DB::update('UPDATE products SET
                            title = ?,
                            slug = ?,
                            category_id = ?,
                            description = ?,
                            price = ?,
                            discountPercentage = ?,
                            stock = ?,
                            brand = ?,
                            thumbnail = ?,
                            updated_at = ?
                        WHERE id = ?', [
                            $request->name,
                            Str::slug($request->name, "_"),
                            $request->category_id,
                            $request->description,
                            $price,
                            $discount,
                            $request->stock,
                            $request->brand,
                            $product->thumbnail,
                            now(),
                            $request->id,
                        ]);

            return redirect()->back()->with(["status" => "success", "message" => "Product updated successfully!"]);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function destroy(Request $request) {
        try {
            // Verifica se o produto existe
            $product = DB::selectOne('SELECT * FROM products WHERE id = ?', [$request->id]);

            if (!$product) {
                return redirect()->back()->with(["status" => "error", "message" => "Product not found!"]);
            }

            // Exclusão do produto usando SQL puro
            DB::delete('DELETE FROM products WHERE id = ?', [$request->id]);

            return redirect()->back()->with(["status" => "success", "message" => "Product removed successfully!"]);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }


    // public function getProductsFromWeb() {
    //     $client = new Client();
    //     $options = [
    //         "http_errors" => true,
    //         "force_ip_resolve" => "v4",
    //         "connect_timeout" => 120,
    //         "red_timeout" => 120,
    //         "timeout" => 120,
    //     ];

    //     $resposne = $client->request("GET", "https://dummyjson.com/products", $options);

    //     $this->storeProducts(json_decode($resposne->getBody(), true));
    // }

    // public function storeProducts($array) {
    //     echo "\nLoading...";

    //     try {
    //         foreach ($array["products"] as $product) {
    //             echo ".";

    //             if (Category::all() == null) {
    //                 $data = [
    //                     "name" => "",
    //                     "slug" => "",
    //                     "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
    //                     "status" => 0,
    //                     "popular" => 0,
    //                     "image" => "https://picsum.photos/id/" . rand(1, 100) . "/200/300"
    //                 ];

    //                 Category::create($data);
    //             }

    //             $data = [
    //                 "title" => $product["title"],
    //                 "slug" => Str::slug($product["title"], "_"),
    //                 "category_id" => 1,
    //                 "description" => $product["description"],
    //                 "price" => $product["price"],
    //                 "discountPercentage" => $product["discountPercentage"],
    //                 "rating" => $product["rating"],
    //                 "stock" => $product["stock"],
    //                 "brand" => $product["brand"],
    //                 "thumbnail" => $product["thumbnail"],
    //             ];

    //             if (!is_dir("public/" . $this->directory)) {
    //                 mkdir("public/" . $this->directory, 0777, true);
    //             }

    //             // save image in local storage
    //             $file = file_get_contents($product["thumbnail"]);
    //             $ext = explode(".", $product["thumbnail"]);
    //             $filename = time() . "." . $ext[count($ext) - 1];
    //             file_put_contents("public/" . $this->directory . $filename, $file);
    //             $data["thumbnail"] = $filename;

    //             // save images in local storage
    //             // $images = [];
    //             // foreach ($product["images"] as $image) {
    //             //     $file = file_get_contents($image);
    //             //     $ext = explode(".", $image);
    //             //     $filename = time() . "." . $ext[count($ext) - 1];
    //             //     file_put_contents("public/" . $this->directory . $filename, $file);
    //             //     $images[] = $filename;
    //             // }
    //             // $data["images"] = json_encode($images);

    //             Product::create($data);
    //         }

    //         echo "\nProducts registered successfully!\n";
    //     } catch (\Throwable $th) {
    //         echo "\n " . $th->getMessage() . "\n";
    //     }

    //     echo "\nEnd of process!\n";
    // }
}
