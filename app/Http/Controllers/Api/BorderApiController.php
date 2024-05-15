<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BorderResource;
use App\Http\Resources\CategoryResource;
use App\Repository\BorderRepository;
use App\Repository\CategoryRepository;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;

class BorderApiController extends Controller
{
    protected $borders;
    use HttpResponses;
    public function __construct(BorderRepository $borders)
    {
        $this->borders = $borders;
    }
    public function index()
    {
        $borders = $this->borders->getAll();
        if($borders){
            return $this->success(
                BorderResource::collection($borders),
                200,
                'All Borders Fetched Successfully'
            );
        }else{
            return $this->error(null,404,'No Product Found');
        }
    }
}
