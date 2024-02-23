<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'material' => $this->material,
            'description' => $this->description,
            'image' => asset('productimg/' . $this->image),
            'price' => $this->price,
            'quantity' => $this->quantity,
            'category_id' => $this->category->id,
            'category_name' => $this->category->name,
            'type_of_meats' => $this->type_of_meats->pluck('name'),
            'type_id' => $this->type ? $this->type->id : null,
            'type_name' => $this->type ? $this->type->name : null,
            'sizes' => $this->sizes->map(function ($size) {
                return [
                    'id' => $size ? $size->id :null,
                    'name' => $size ? $size->name : null,
                    'price' => $size->pivot->price
                ];
            }),
        ];
    }
}