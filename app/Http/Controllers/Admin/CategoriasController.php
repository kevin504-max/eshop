<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CategoriasController extends Controller
{
    public function index () {
        try {
            $categorias = Categoria::all();
            return view('admin.categoria.index', compact('categorias'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao acessar a página de categorias! Tente novamente."]);
        }
    }

    public function store (Request $request) {
        try {
            $categoria = new Categoria();

            if ($request->hasFile("imagem")) {
                $file = $request->file("imagem");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move("assets/uploads/categoria/", $filename);
                $categoria->imagem = $filename;
            }

            $categoria->nome = $request->nome;
            $categoria->slug = $request->slug;
            $categoria->descricao = $request->descricao;
            $categoria->status = ($request->status == TRUE) ? 1 : 0;
            $categoria->popular = ($request->popular == TRUE) ? 1 : 0;
            $categoria->meta_titulo = $request->meta_titulo;
            $categoria->meta_keywords = $request->meta_keywords;
            $categoria->meta_descricao = $request->meta_descricao;
            $categoria->save();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Categoria adicionada com sucesso!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao adicionar categoria! Tente novamente."]);
        }
    }

    public function update(Request $request) {
        try {
            $categoria = Categoria::findOrFail($request->id);

            if ($request->hasFile("imagem")) {
                $path = "assets/uploads/categoria/" . $categoria->imagem;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file("imagem");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move("assets/uploads/categoria/", $filename);
                $categoria->imagem = $filename;
            }

            $categoria->nome = $request->nome;
            $categoria->slug = $request->slug;
            $categoria->descricao = $request->descricao;
            $categoria->status = ($request->status == TRUE) ? 1 : 0;
            $categoria->popular = ($request->popular == TRUE) ? 1 : 0;
            $categoria->meta_titulo = $request->meta_titulo;
            $categoria->meta_keywords = $request->meta_keywords;
            $categoria->meta_descricao = $request->meta_descricao;
            $categoria->update();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Categoria atualizada com sucesso!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao atualizar categoria! Tente novamente."]);
        }
    }

    public function destroy(Request $request) {
        try {
            $categoria = Categoria::findOrFail($request->id);

            if ($categoria->imagem) {
                $path = "assets/uploads/categoria/" . $categoria->imagem;

                if (File::exists($path)) {
                    File::delete($path);
                }
            }

            $categoria->delete();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Categoria removida com sucesso!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao remover categoria! Tente novamente."]);
        }
    }
}
