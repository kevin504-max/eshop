<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $directory = "assets/uploads/product/";

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

            if ($request->hasFile("thumbnail")) {
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

            $product->title = $request->name;
            $product->slug = Str::slug($request->name, "_");
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->price = $price;
            $product->discountPercentage = $discount;
            $product->rating = 0;
            $product->stock = $request->stock;
            $product->brand = $request->brand;
            $product->save();

            return redirect()->back()->with(["status" => "success", "message" => "Product registered successfully!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function update(Request $request) {
        try {
            $product = Product::findOrFail($request->id);

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

            $product->title = $request->name;
            $product->slug = Str::slug($request->name, "_");
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->price = $price;
            $product->discountPercentage = $discount;
            $product->stock = $request->stock;
            $product->brand = $request->brand;
            $product->update();

            return redirect()->back()->with(["status" => "success", "message" => "Product updated successfully!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function destroy(Request $request) {
        try {
            $product = Product::findOrFail($request->id);
            $product->delete();

            return redirect()->back()->with(["status" => "success", "message" => "Product removed successfully!"]);
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
        echo "\nLoading...";

        try {
            foreach ($array["products"] as $product) {
                echo ".";

                if (Category::all() == null) {
                    $data = [
                        "name" => "",
                        "slug" => "",
                        "description" => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quisquam, voluptatum.",
                        "status" => 0,
                        "popular" => 0,
                        "image" => "https://picsum.photos/id/" . rand(1, 100) . "/200/300"
                    ];

                    Category::create($data);
                }

                $data = [
                    "title" => $product["title"],
                    "slug" => Str::slug($product["title"], "_"),
                    "category_id" => 1,
                    "description" => $product["description"],
                    "price" => $product["price"],
                    "discountPercentage" => $product["discountPercentage"],
                    "rating" => $product["rating"],
                    "stock" => $product["stock"],
                    "brand" => $product["brand"],
                    "thumbnail" => $product["thumbnail"],
                ];

                if (!is_dir("public/" . $this->directory)) {
                    mkdir("public/" . $this->directory, 0777, true);
                }

                // save image in local storage
                $file = file_get_contents($product["thumbnail"]);
                $ext = explode(".", $product["thumbnail"]);
                $filename = time() . "." . $ext[count($ext) - 1];
                file_put_contents("public/" . $this->directory . $filename, $file);
                $data["thumbnail"] = $filename;

                // save images in local storage
                // $images = [];
                // foreach ($product["images"] as $image) {
                //     $file = file_get_contents($image);
                //     $ext = explode(".", $image);
                //     $filename = time() . "." . $ext[count($ext) - 1];
                //     file_put_contents("public/" . $this->directory . $filename, $file);
                //     $images[] = $filename;
                // }
                // $data["images"] = json_encode($images);

                Product::create($data);
            }

            echo "\nProducts registered successfully!\n";
        } catch (\Throwable $th) {
            echo "\n " . $th->getMessage() . "\n";
        }

        echo "\nEnd of process!\n";
    }
}
