<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    protected $directory = "assets/uploads/category/";

    public function index() {
        try {
            // Obter todas as categorias
            $query = DB::select('SELECT * FROM categories');

            $categories = array_map(function ($category) {
                return (array) $category;
            }, $query);

            return view('admin.category.index', compact('categories'));
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }


    public function store(Request $request) {
        try {
            // Manipulação de arquivo
            $image = null;
            if ($request->hasFile("image")) {
                $file = $request->file("image");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move($this->directory, $filename);
                $image = $filename;
            }

            // Inserção de dados usando SQL puro
            DB::insert('INSERT INTO categories (name, slug, description, status, popular, image, created_at, updated_at)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                            $request->name,
                            $request->slug,
                            $request->description,
                            ($request->status == true) ? 1 : 0,
                            ($request->popular == true) ? 1 : 0,
                            $image,
                            now(),
                            now(),
                        ]);

            return redirect()->back()->with(["status" => "success", "message" => "Category registered successfully!"]);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function update(Request $request) {
        try {
            $category = DB::selectOne('SELECT * FROM categories WHERE id = ?', [$request->id]);

            if (!$category) {
                return redirect()->back()->with(["status" => "error", "message" => "Category not found!"]);
            }

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

            // Atualização de dados usando SQL puro
            DB::update('UPDATE categories SET
                            name = ?,
                            slug = ?,
                            description = ?,
                            status = ?,
                            popular = ?,
                            image = ?,
                            updated_at = ?
                        WHERE id = ?', [
                            $request->name,
                            $request->slug,
                            $request->description,
                            ($request->status == true) ? 1 : 0,
                            ($request->popular == true) ? 1 : 0,
                            $category->image,
                            now(),
                            $request->id,
                        ]);

            return redirect()->back()->with(["status" => "success", "message" => "Category updated successfully!"]);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }

    public function destroy(Request $request) {
        try {
            $category = DB::selectOne('SELECT * FROM categories WHERE id = ?', [$request->id]);

            if (!$category) {
                return redirect()->back()->with(["status" => "error", "message" => "Category not found!"]);
            }

            if ($category->image) {
                $path = $this->directory . $category->image;

                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            // Exclusão da categoria usando SQL puro
            DB::delete('DELETE FROM categories WHERE id = ?', [$request->id]);

            return redirect()->back()->with(["status" => "success", "message" => "Category removed successfully!"]);
        } catch (\Throwable $th) {
            report($th);
            return redirect()->back()->with(["status" => "error", "message" => "Something went wrong! Try again."]);
        }
    }
}
