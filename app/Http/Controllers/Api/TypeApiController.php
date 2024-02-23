<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TypeResource;
use App\Repository\TypeRepository;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class TypeApiController extends Controller
{
    protected $type;
    use HttpResponses;
    public function __construct(TypeRepository $type)
    {
        $this->type = $type;
    }
    public function index()
    {
        $types = $this->type->getAll();
        if($types){
            return $this->success(
                TypeResource::collection($types),
                200,
                'All Products Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Product Found');
        }
    }
}
