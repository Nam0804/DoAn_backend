<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeOfMeat extends Model
{
    use HasFactory;
    protected $table = 'type_of_meats';
    protected $guarded = [];
    //relation many to many to product
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_meat', 'meat_id', 'product_id');
    }
}
