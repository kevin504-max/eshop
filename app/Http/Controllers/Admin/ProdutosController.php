<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Produto;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdutosController extends Controller
{
    public function index()
    {
        try {
            $produtos = Produto::all();
            $categorias = Categoria::where("status", 1)->get();
            return view('admin.produto.index', compact('produtos', 'categorias'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao acessar a página de produtos! Tente novamente."]);
        }
    }

    public function store(Request $request)
    {
        try {
            $produto = new Produto();
            $categoria = Categoria::findOrFail($request->categoria_id);

            if ($request->hasFile("thumbnail")) {
                $file = $request->file("thumbnail");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move("assets/uploads/produto/", $filename);
                $produto->thumbnail = $filename;
            }

            if ($request->hasFile("imagens")) {
                $imagens = [];

                foreach ($request->file("imagens") as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $filename = time() . "." . $ext;
                    $file->move("assets/uploads/produto/", $filename);
                    $imagens[] = $filename;
                }

                $produto->images = json_encode($imagens);
            }

            $preco = str_replace(",", ".", $request->preco);
            $preco = str_replace(".", "", $preco);
            $desconto = str_replace(",", ".", $request->desconto);
            $desconto = str_replace(".", "", $desconto);

            $produto->title = $request->nome;
            $produto->category_id = $categoria->id;
            $produto->description = $request->descricao;
            $produto->price = $preco;
            $produto->discountPercentage = $desconto;
            $produto->rating = $request->rating;
            $produto->stock = $request->estoque;
            $produto->brand = $request->marca;
            $produto->category = $categoria->nome;
            $produto->save();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Produto adicionado com sucesso!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao adicionar produto! Tente novamente."]);
        }
    }

    public function update(Request $request)
    {
        try {
            $produto = Produto::findOrFail($request->id);
            $categoria = Categoria::findOrFail($request->categoria_id);

            if ($request->hasFile("thumbnail")) {
                $path = "assets/uploads/produto/" . $produto->thumbnail;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $file = $request->file("thumbnail");
                $ext = $file->getClientOriginalExtension();
                $filename = time() . "." . $ext;
                $file->move("assets/uploads/produto/", $filename);
                $produto->thumbnail = $filename;
            }

            if ($request->hasFile("imagens")) {
                $path = "assets/uploads/produto/" . $produto->images;

                if (File::exists($path)) {
                    File::delete($path);
                }

                $imagens = [];

                foreach ($request->file("imagens") as $file) {
                    $ext = $file->getClientOriginalExtension();
                    $filename = time() . "." . $ext;
                    $file->move("assets/uploads/produto/", $filename);
                    $imagens[] = $filename;
                }

                $produto->images = json_encode($imagens);
            }

            $produto->title = $request->nome;
            $produto->category_id = $categoria->id;
            $produto->description = $request->descricao;
            $produto->price = $request->preco;
            $produto->discountPercentage = $request->desconto;
            $produto->rating = $request->rating;
            $produto->stock = $request->estoque;
            $produto->brand = $request->marca;
            $produto->category = $categoria->nome;
            $produto->update();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Produto atualizado com sucesso!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao atualizar produto! Tente novamente."]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $produto = Produto::findOrFail($request->id);
            $produto->delete();

            return redirect("/dashboard")->with(["status" => "success", "message" => "Produto removido com sucesso!"]);
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao remover produto! Tente novamente."]);
        }
    }

    public function getProdutosFromWeb()
    {
        $client = new Client();
        $options = [
            "http_errors" => true,
            "force_ip_resolve" => "v4",
            "connect_timeout" => 120,
            "red_timeout" => 120,
            "timeout" => 120,
        ];

        $resposne = $client->request("GET", "https://dummyjson.com/products", $options);

        $this->storeProdutos(json_decode($resposne->getBody(), true));
    }

    public function storeProdutos($array)
    {
        echo "Guardando produtos...";

        try {
            foreach ($array["products"] as $produto) {
                echo ".";

                $dados = [
                    "title" => $produto["title"],
                    "category_id" => -1,
                    "description" => $produto["description"],
                    "price" => $produto["price"],
                    "discountPercentage" => $produto["discountPercentage"],
                    "rating" => $produto["rating"],
                    "stock" => $produto["stock"],
                    "brand" => $produto["brand"],
                    "category" => $produto["category"],
                    "thumbnail" => $produto["thumbnail"],
                    "images" => json_encode($produto["images"])
                ];

                Produto::create($dados);
            }

            echo "\nProdutos guardados com sucesso!\n";
        } catch (\Throwable $th) {
            echo "\n " . $th->getMessage() . "\n";
        }

        echo "\Fim da execução!\n";
    }
}
