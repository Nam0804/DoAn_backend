<?php
namespace App\Repository;

use App\Models\Topping;
use App\Repository\interface\ToppingRepositoryInterface;
use Illuminate\Support\Facades\Request;

class ToppingRepository implements ToppingRepositoryInterface
{
    public function getAll()
    {
        $toppings = Topping::all();
        return $toppings;
    }
}