<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

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
    //relation many to many to base
    public function bases()
    {
        return $this->belongsToMany(Base::class, 'product_bases', 'product_id', 'base_id');
    }
    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'product_toppings')->withPivot('size_id','price');
    }
    public function borders()
    {
        return $this->belongsToMany(Border::class, 'product_borders', 'product_id', 'border_id')->withPivot('size_id','price');
    }
    public function carts()
    {
        return $this->belongsTo(Cart::class);
    }
}


