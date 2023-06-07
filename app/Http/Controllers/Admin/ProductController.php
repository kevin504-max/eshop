<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index() {
        try {
            $products = Product::all();
            $categories = Category::where("status", 1)->get();
            return view('admin.product.index', compact('products', 'categories'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function store(Request $request) {
        try {
            $product = new Product();
            $category = Category::findOrFail($request->category_id);

            if ($request->hasFile("thumbnail")) {
                $file = $request->file("thumbnail");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move("assets/uploads/product/", $filename);
                $product->thumbnail = $filename;
            }

            if ($request->hasFile("images")) {
                $images = [];

                foreach ($request->file("images") as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $filename = time() . "." . $ext;
                    $file->move("assets/uploads/product/", $filename);
                    $images[] = $filename;
                }

                $product->images = json_encode($images);
            }

            $price = str_replace(",", ".", $request->price);
            $price = str_replace(".", "", $price);
            $discount = str_replace(",", ".", $request->discount);
            $discount = str_replace(".", "", $discount);

            $product->title = $request->name;
            $product->category_id = $category->id;
            $product->description = $request->description;
            $product->price = $price;
            $product->discountPercentage = $discount;
            $product->rating = 0;
            $product->stock = $request->stock;
            $product->brand = $request->brand;
            $product->category = $category->name;
            $product->save();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Product registered successfully!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function update(Request $request) {
        try {
            $product = Product::findOrFail($request->id);
            $category = Category::findOrFail($request->category_id);

            if ($request->hasFile("thumbnail")) {
                $path = "assets/uploads/product/" . $product->thumbnail;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file("thumbnail");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move("assets/uploads/product/", $filename);
                $product->thumbnail = $filename;
            }

            if ($request->hasFile("images")) {
                $path = "assets/uploads/product/" . $product->images;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $images = [];

                foreach ($request->file("images") as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $filename = time() . "." . $ext;
                    $file->move("assets/uploads/product/", $filename);
                    $images[] = $filename;
                }

                $product->images = json_encode($images);
            }

            $product->title = $request->name;
            $product->category_id = $category->id;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->discountPercentage = $request->discount;
            $product->stock = $request->stock;
            $product->brand = $request->brand;
            $product->category = $category->name;
            $product->update();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Product updated successfully!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function destroy(Request $request) {
        try {
            $product = Product::findOrFail($request->id);
            $product->delete();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Product removed successfully!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function getProductsFromWeb() {
        $client = new Client();
        $options = [
            "http_errors" => true,
            "force_ip_resolve" => "v4",
            "connect_timeout" => 120,
            "red_timeout" => 120,
            "timeout" => 120,
        ];

        $resposne = $client->request("GET", "https://dummyjson.com/products", $options);

        $this->storeProducts(json_decode($resposne->getBody(), true));
    }

    public function storeProducts($array) {
        echo "\nLoading...\n";

        try {
            foreach ($array["products"] as $product) {
                echo ".";

                $datas = [
                    "title" => $product["title"],
                    "category_id" => -1,
                    "description" => $product["description"],
                    "price" => $product["price"],
                    "discountPercentage" => $product["discountPercentage"],
                    "rating" => $product["rating"],
                    "stock" => $product["stock"],
                    "brand" => $product["brand"],
                    "category" => $product["category"],
                    "thumbnail" => $product["thumbnail"],
                    "images" => json_encode($product["images"])
                ];

                Product::create($datas);
            }

            echo "\nProducts registered successfully!\n";
        } catch (\Throwable $th) {
            echo "\n " . $th->getMessage() . "\n";
        }

        echo "\End of process!\n";
    }
}
