<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductMeat extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'product_meat';
    protected $guarded = [];
}


