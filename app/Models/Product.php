<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];
    //relation 1-1 to category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    //relation many to many to type_of_meat
    public function type_of_meats()
    {
        return $this->belongsToMany(TypeOfMeat::class, 'product_meat', 'product_id', 'meat_id');
    }
    //relation one to one to type
    public function type()
    {
        return $this->belongsTo(Type::class);
    }
    //relation one to many to size
    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')->withPivot('price');
    }
    //relation to product_sizes no table
}


