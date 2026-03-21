<?php

namespace App\Repository;

use App\Models\Blog;
use App\Models\Category;
use App\Repository\interface\BlogRepositoryInterface;
use App\Repository\interface\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Request;

class BlogRepository implements BlogRepositoryInterface
{
    public function createBlog($request)
    {
        $name = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = md5_file($image->getRealPath()) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/bloguploadimg'), $name);
        }
        $blog= new Blog();
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->image = $name;
        $blog->article = $request->input('article');
        $blog->save();
        return $blog;
    }
    public function getBlogs()
    {
        $blogs = Blog::all();
        return $blogs;
    }
    public function getBlogById($id)
    {
        $blog = Blog::find($id);
        return $blog;
    }
    public function editBlog($request,$id)
    {
        //dd($request->all());
        $blog = Blog::find($id);
        $name=null;
        if ($request->hasFile('newimage')) {
            $image = $request->file('newimage');
            $name = $image->getRealPath() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/bloguploadimg'), $name);
        }else{
            $name = $blog->image;
        }
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->image = $name;
        $blog->article = $request->input('article');
        $blog->save();
        return $blog;
    }
}
