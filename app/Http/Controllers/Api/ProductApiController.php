<?php

namespace App\Http\Controllers\Api;
use App\Traits\HttpResponses;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Repository\interface\ProductRepositoryInterface;
use App\Repository\ProductsRepository;

class ProductApiController extends Controller
{
    protected $product;
    use HttpResponses;
    public function __construct(ProductsRepository $product)
    {
        $this->product = $product;
    }
    public function index()
    {
         $products = $this->product->getAll();
        //$products = Product::all();
        if($products){
            return $this->success(
                ProductResource::collection($products),
                200,
                'All Products Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Product Found');
        }
    }
    public function getAllById($id,Request $request,)
    {
        $product = $this->product->getAllProductById($id,$request);

        if($product){
            return $this->success(
                ProductResource::collection($product),
                200,
                'All Products Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Product Found');
        }
    }
    public function store(Request $request)
    {
        $product = $this->product->storeProduct($request);
        if($product){
            return $this->success(
                new ProductResource($product),
                201,
                'Product Created Successfully'
            );
        }else{
            return $this->error(null,404,'Product Not Created');
        }
    }
}
