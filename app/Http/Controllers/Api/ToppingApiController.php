<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BorderResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ToppingResource;
use App\Repository\BorderRepository;
use App\Repository\CategoryRepository;
use App\Repository\ToppingRepository;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class ToppingApiController extends Controller
{
    protected $toppings;
    use HttpResponses;
    public function __construct(ToppingRepository $toppings)
    {
        $this->toppings = $toppings;
    }
    public function index()
    {
        $toppings = $this->toppings->getAll();
        if($toppings){
            return $this->success(
                ToppingResource::collection($toppings),
                200,
                'All toppings Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No toppings Found');
        }
    }
}
