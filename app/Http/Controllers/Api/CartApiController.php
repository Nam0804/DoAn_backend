<?php

namespace App\Http\Controllers\Api;

use App\Traits\HttpResponses;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Repository\CartRepository;

class CartApiController extends Controller
{
    protected $cart;
    use HttpResponses;
    public function __construct(CartRepository $cart)
    {
        $this->cart = $cart;
    }
    public function store(Request $request)
    {
        $cart = $this->cart->storeProductToCart($request);
        if ($cart) {
            return $this->success(
                new CartResource($cart),
                201,
                'Product Created Successfully'
            );
        } else {
            return $this->error(null, 404, 'Product Not Created');
        }
    }
    public function deleteAll()
    {
        $cart = $this->cart->deleteAllFromCart();
        if ($cart) {
            return $this->success(
                null,
                201,
                'Product Deleted Successfully'
            );
        } else {
            return $this->error(null, 404, 'Product Not Deleted');
        }
    }
    
}
