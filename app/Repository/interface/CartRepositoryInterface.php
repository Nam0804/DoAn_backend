<?php

namespace App\Repository\interface;

interface CartRepositoryInterface
{
    // public function getAll();
    // public function getAllProductById($id,$request);
    public function storeProductToCart($request);
    public function deleteAllFromCart();
}