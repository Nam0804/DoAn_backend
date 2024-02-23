<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeOfMeatResource;
use App\Models\TypeOfMeat;
use App\Repository\TypeOfMeatRepository;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class TypeOfMeatApiController extends Controller
{
    protected $typeofmeat;
    use HttpResponses;
    public function __construct(TypeOfMeatRepository $typeofmeat)
    {
        $this->typeofmeat = $typeofmeat;
    }
    public function index()
    {
        $typeofmeats = $this->typeofmeat->getAll();
        if($typeofmeats){
            return $this->success(
                TypeOfMeatResource::collection($typeofmeats),
                200,
                'All Products Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Product Found');
        }
    }
}
