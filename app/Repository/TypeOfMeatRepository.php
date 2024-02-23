<?php
namespace App\Repository;

use App\Models\Category;
use App\Models\TypeOfMeat;
use App\Repository\interface\TypeOfMeatRepositoryInterface;
use Illuminate\Support\Facades\Request;

class TypeOfMeatRepository implements TypeOfMeatRepositoryInterface
{
    public function getAll()
    {
        $tom = TypeOfMeat::all();
        return $tom;
    }
}