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
            // Upload thẳng lên Cloudinary và lấy về cái link bảo mật (https)
            $uploadedFileUrl = cloudinary()->upload($request->file('image')->getRealPath())->getSecurePath();
            $imageUrl = $uploadedFileUrl;
        }
        $blog= new Blog();
        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->image = $name;
        $blog->article = $request->input('article');
        $blog->status = $request->input('status');
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
        $blog = Blog::find($id);

        if ($request->hasFile('newimage')) {
            $uploadedFileUrl = cloudinary()->upload($request->file('newimage')->getRealPath())->getSecurePath();
            $blog->image = $uploadedFileUrl;
        }

        $blog->title = $request->input('title');
        $blog->content = $request->input('content');
        $blog->article = $request->input('article');
        $blog->status = $request->input('status');
        $blog->save();

        return $blog;
    }
}
