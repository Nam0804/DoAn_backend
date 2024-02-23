<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class CategoryApiController extends Controller
{
    protected $categories;
    use HttpResponses;
    public function __construct(CategoryRepository $categories)
    {
        $this->categories = $categories;
    }
    public function index()
    {
        $categories = $this->categories->getAll();
        if($categories){
            return $this->success(
                CategoryResource::collection($categories),
                200,
                'All Products Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Product Found');
        }
    }
}
