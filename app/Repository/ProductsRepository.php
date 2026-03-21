<?php

namespace App\Repository;

use App\Models\Base;
use App\Repository\interface\ProductRepositoryInterface;
use App\Models\Product;
use App\Models\ProductBorder;
use App\Models\ProductMeat;
use App\Models\ProductSize;
use App\Models\ProductTopping;
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
    public function getAllProductById($id, $request)
    {
        $tomid = $request->input('type_of_meat_id');
        if ($tomid == 0 || !$tomid) {
            $final = Product::where('category_id', $id)->get();
        } else {
            $result = TypeOfMeat::where('id', $tomid)->first();
            if ($result) {
                $final = $result->products->where('category_id', $id);
            } else {
                $final = [];
            }
        }
        $bases = Base::all(['id', 'name']);
        foreach ($final as $finalproduct) {
            if ($finalproduct->category_id == 1) {
                if ($finalproduct->bases->count() === 0) {
                    $finalproduct->bases()->attach($bases->pluck('id')->toArray());
                }
            }
        }
        return $final;
    }
    public function getProductById($id)
    {
        $product = Product::find($id);
        return $product;
    }
    public function storeProduct($request)
    {
        try{
        $name = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/productimg'), $name);
        }
        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category_id');
        $product->type_id = $request->input('type_id');
        $product->price = $request->input('price');
        $product->image = $name;
        $product->save();
        //thông tin của sp mới thêm
        $productId = $product->id;
        if ($request->has('meats') && $request->input('meats') != null) {
            $meats = json_decode($request->input('meats'), true);
            foreach ($meats as $meatId) {
                ProductMeat::create([
                    'product_id' => $productId,
                    'meat_id' => $meatId,
                ]);
            }
        }
        if($request->has('topping_list') && $request->input('topping_list') != null){
            $toppingList = json_decode($request->input('topping_list'), true);
            foreach ($toppingList as $topping) {
                ProductTopping::create([
                    'product_id' => $productId,
                    'topping_id' => $topping['topping'],
                    'size_id' => $topping['size'],
                    'price' => $topping['price'],
                ]);
            }
        }
        if($request->has('border_list') && $request->input('border_list') != null){
            $borderList = json_decode($request->input('border_list'), true);
            foreach ($borderList as $border) {
                ProductBorder::create([
                    'product_id' => $productId,
                    'border_id' => $border['border'],
                    'size_id' => $border['size'],
                    'price' => $border['price'],
                ]);
            }
        }
        if($request->has('size_list') && $request->input('size_list') != null){
            $sizeList = json_decode($request->input('size_list'), true);
            foreach ($sizeList as $size) {
                ProductSize::create([
                    'product_id' => $productId,
                    'size_id' => $size['size'],
                    'price' => $size['price'],
                ]);
            }
        }
        return $product;
        }catch(\Exception $e){
            dd($e);
            return $e;
        }
    }
    public function deleteProduct($id)
    {
        $product = Product::find($id);
        $product->delete();
        return $product;
    }
    public function editProduct($request, $id)
    {
    }
}
