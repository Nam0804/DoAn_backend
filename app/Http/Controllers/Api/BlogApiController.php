<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Repository\BlogRepository;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class BlogApiController extends Controller
{
    protected $blog;
    use HttpResponses;
    public function __construct(BlogRepository $blog)
    {
        $this->blog = $blog;
    }
    public function index()
    {
        $blogs = $this->blog->getBlogs();
        return $this->success(
            BlogResource::collection($blogs),
            200,
            'All Products'
        );
    }
    public function show($id)
    {
        $blog = $this->blog->getBlogById($id);
        if ($blog) {
            return $this->success(
                new BlogResource($blog),
                200,
                'Product Found'
            );
        } else {
            return $this->error(null, 404, 'Product Not Found');
        }
    }
    public function store(Request $request)
    {
        
        $blog = $this->blog->createBlog($request);
        if ($blog) {
            return $this->success(
                new BlogResource($blog),
                201,
                'Product Created Successfully'
            );
        } else {
            return $this->error(null, 404, 'Product Not Created');
        }
    }
    public function update(Request $request,$id)
    {
        $blog = $this->blog->editBlog($request,$id);
        if ($blog) {
            return $this->success(
                new BlogResource($blog),
                201,
                'Product Updated Successfully'
            );
        } else {
            return $this->error(null, 404, 'Product Not Updated');
        }
    }
}
