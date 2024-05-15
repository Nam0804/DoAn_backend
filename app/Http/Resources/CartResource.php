<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class CartResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            //'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            // 'product' => new ProductResource($this->product),
            'base' => $this->base,
            'toppings' => $this->topping,
            'borders' => $this->border,
            'size' => $this->size,
            'price' => $this->price,
            
        ];
    }
}