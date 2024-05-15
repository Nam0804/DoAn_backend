<?php
namespace App\Repository\Interface;

interface BlogRepositoryInterface
{
    public function createBlog($request);
    public function getBlogs();
    public function getBlogById($id);
    public function editBlog($request,$id);
}