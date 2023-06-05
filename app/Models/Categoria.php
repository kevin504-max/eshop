<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = "categorias";

    protected $fillable = [
        "nome",
        "slug",
        "descricao",
        "status",
        "popular",
        "imagem",
        "meta_titulo",
        "meta_descricao",
        "meta_keywords"
    ];
}
