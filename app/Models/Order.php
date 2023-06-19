<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $fillable = [
        'user_id',
        'username',
        'email',
        'state',
        'city',
        'cpf_cnpj',
        'phone',
        'status',
        'total_price',
        'message',
        'tracking_number'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
