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
    $imageUrl = null; // Khởi tạo biến này

    if ($request->hasFile('image')) {
        // Upload và gán thẳng vào $imageUrl
        $imageUrl = cloudinary()->upload($request->file('image')->getRealPath())->getSecurePath();
    }

    $blog = new Blog();
    $blog->title = $request->input('title');
    $blog->content = $request->input('content');
    $blog->image = $imageUrl; // <-- Dùng đúng biến $imageUrl đã có link Cloudinary
    $blog->article = $request->input('article');
    $blog->status = $request->input('status', '0'); // Mặc định là 0 nếu không có
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
    public function editBlog($request, $id)
{
    $blog = Blog::find($id);

    if ($request->hasFile('newimage')) {
        // Sửa tương tự cho đồng bộ
        $imageUrl = cloudinary()->upload($request->file('newimage')->getRealPath())->getSecurePath();
        $blog->image = $imageUrl;
    }

    $blog->title = $request->input('title');
    $blog->content = $request->input('content');
    $blog->article = $request->input('article');
    $blog->status = $request->input('status', $blog->status);
    $blog->save();

    return $blog;
}
}
