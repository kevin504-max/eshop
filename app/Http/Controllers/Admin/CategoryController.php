<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    protected $directory = "assets/uploads/category/";

    public function index () {
        try {
            $categories = Category::all();
            return view('admin.category.index', compact('categories'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function store (Request $request) {
        // try {
            $category = new Category();

            if ($request->hasFile("image")) {
                $file = $request->file("image");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move($this->directory, $filename, 0777, true);
                $category->image = $filename;
            }

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->description = $request->description;
            $category->status = ($request->status == TRUE) ? 1 : 0;
            $category->popular = ($request->popular == TRUE) ? 1 : 0;
            $category->save();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Category registered successfully!"]);
        // } catch (\Throwable $th) {
        //     report ($th);
        //     return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        // }
    }

    public function update(Request $request) {
        try {
            $category = Category::findOrFail($request->id);

            if ($request->hasFile("image")) {
                $path = $this->directory . $category->image;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file("image");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move($this->directory, $filename);
                $category->image = $filename;
            }

            $category->name = $request->name;
            $category->slug = $request->slug;
            $category->description = $request->description;
            $category->status = ($request->status == TRUE) ? 1 : 0;
            $category->popular = ($request->popular == TRUE) ? 1 : 0;
            $category->update();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Category updated successfully!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function destroy(Request $request) {
        try {
            $category = Category::findOrFail($request->id);

            if ($category->image) {
                $path = $this->directory . $category->image;

                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $category->delete();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Category removed successfully!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }


}
