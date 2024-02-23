<?php

namespace App\Repository\interface;

interface ProductRepositoryInterface
{
    public function getAll();
    public function getAllProductById($id,$request);
    public function storeProduct($request);
}