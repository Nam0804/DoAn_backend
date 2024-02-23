<?php
namespace App\Repository;

use App\Models\Type;
use App\Repository\interface\TypeRepositoryInterface;
use Illuminate\Support\Facades\Request;

class TypeRepository implements TypeRepositoryInterface
{
    public function getAll()
    {
        $type = Type::all();
        return $type;
    }
}