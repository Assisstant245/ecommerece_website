<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
    'cart_product_name',
    'cart_product_sku',
    'cart_product_image',
    'cart_product_sale_price',
    'cart_quantity',
    'user_id',
    'total_price'
];
}
