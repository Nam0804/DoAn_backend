<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class InvoiceDetailResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,
            'quantity' => $this->quantity,
            'base_name' => $this->base_name,
            'size_name' => $this->size_name,
            'topping_name' => $this->topping_name,
            'border_name' => $this->border_name,
            'price' => $this->price,
            'border' => $this->border,
            'topping' => $this->topping,
            'size' => $this->size,
            'sub_total' => $this->sub_total,
        ];
    }
}