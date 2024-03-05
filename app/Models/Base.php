<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    use HasFactory;
    protected $table = 'bases';
    protected $guarded = [];
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_bases','base_id','product_id');
    }
}
