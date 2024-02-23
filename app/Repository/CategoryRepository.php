<?php
namespace App\Repository;

use App\Models\Category;
use App\Repository\interface\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Request;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAll()
    {
        $categories = Category::all();
        return $categories;
    }
}