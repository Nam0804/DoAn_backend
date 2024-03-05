<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Border extends Model
{
    use HasFactory;
    protected $table = 'borders';
    protected $guarded = [];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_borders', 'border_id', 'product_id');
    }
}
