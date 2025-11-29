<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
        protected $fillable = [
                'product_name',
                'product_description',
                'product_image',
                'product_price',
                'product_whole_price',
                'sku',
                'product_status',
                'category_id',
                'subcategory_id'
        ];

        public function category()
        {
        return $this->belongsTo(Category::class);
        }

        public function subcategory()
        {
        return $this->belongsTo(SubCategory::class);
        }
}
