<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produto;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ProdutosController extends Controller
{
    public function index()
    {
        try {
            $produtos = Produto::all();
            return view('admin.produto.index', compact('produtos'));
        } catch (\Throwable $th) {
            report ($th);
            return redirect()->back()->with(["status" => "error", "message" => "Erro ao acessar a página de produtos! Tente novamente."]);
        }
    }

    public function store(Request $request)
    {
        dd("Function Store!!");
        dd($request->all());
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
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
