<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    Protected $fillable=['category_name','category_description'];
    public function subcategories()
    {
        return $this->hasMany(SubCategory::class);
    }  

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
