<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = "produtos";
    protected $fillable = [
        "title",
        "category_id",
        "description",
        "price",
        "discountPercentage",
        "rating",
        "stock",
        "brand",
        "category",
        "thumbnail",
        "images"
    ];

    public function categoria () {
        return $this->belongsTo(Categoria::class, "category_id", "id");
    }
}
