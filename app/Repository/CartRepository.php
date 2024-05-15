<?php
namespace App\Repository;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductBorder;
use App\Models\ProductSize;
use App\Models\ProductTopping;
use App\Models\Size;
use App\Repository\interface\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function storeProductToCart($request)
    {
        //dd($request->all());
        $sizeprice = ProductSize::where('product_id',$request->product_id)->where('size_id',$request->size)->pluck('price')->first();
        if($request->has('topping')){
            $toppingprice = ProductTopping::where('product_id',$request->product_id)->where('topping_id',$request->topping)->pluck('price')->first();
        }else
        {
            $toppingprice = 0;
        }
        if($request->has('border')){
            $borderprice = ProductBorder::where('product_id',$request->product_id)->where('border_id',$request->border)->pluck('price')->first();
        }else
        {
            $borderprice = 0;
        }
        $cart = new Cart();
        $cart->product_id = $request->product_id;
        $cart->quantity = $request->quantity;
        $cart->base = $request->base;
        $cart->border = $request->has('border') ? $request->border : null;
        $cart->topping = $request->has('border') ? $request->topping : null;
        $cart->topping = $request->has('topping') ? $request->topping : null;
        $cart->size = $request->size;
        $cart->price = $request->has('price') ? $request->price : null;
        $cart->total = ($sizeprice + $toppingprice + $borderprice) * $request->quantity;
        $cart->save();
        return $cart;
    }
    public function deleteAllFromCart()
    {
        $cart = Cart::truncate();
        return $cart;
    }
}