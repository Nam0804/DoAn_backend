<?php
namespace App\Repository;

use App\Models\Border;
use App\Repository\interface\BorderRepositoryInterface;
use Illuminate\Support\Facades\Request;

class BorderRepository implements BorderRepositoryInterface
{
    public function getAll()
    {
        $borders = Border::all();
        return $borders;
    }
}