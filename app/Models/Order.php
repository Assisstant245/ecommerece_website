<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
                'first_name',
                'last_name',
                'order_email',
                'mobile_no',
                'country',
                'city',
                'state',
                'address',
                'zip_code',
                'product_items',
                'user_id',
                'order_status',
                'total_price',
                'order_product_image',
        ];

}
