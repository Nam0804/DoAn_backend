<?php
namespace App\Repository;

use App\Repository\Interface\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\TypeOfMeat;
use Illuminate\Support\Facades\Request;
use Mockery\Matcher\Type;

class ProductsRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        $products = Product::all();
        return $products;
    }
    public function getAllProductById($id,$request)
    {
        $tomid=$request->input('type_of_meat_id');
        //nếu không có request hoặc có request giá trị là 0 thì lấy tất cả sản phẩm thuộc $id
        if($tomid==0 || !$tomid)
        {
            $final = Product::where('category_id',$id)->get();
        }
        else{
            $result = TypeOfMeat::where('id',$tomid)->first();
            if($result)
            {
                $final = $result->products->where('category_id',$id);
            }
            else
            {
                $final = [];
            }
        }
        return $final;
    }
    public function storeProduct($request)
    {
        $name = null;
        if($request->hasFile('image')){
            $image = $request->file('image');
            $name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/productimg'), $name);
        }
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->price = $request->input('price');
        $product->image = $name;
        $product->save();
        if($request->has('meats' || $request->input('meats')!=null))
        {
            $product->type_of_meats()->attach($request->input('meats'));
        }
        return $product;
    }
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }
    public function editProduct($request,$id)
    {
        
    }
}