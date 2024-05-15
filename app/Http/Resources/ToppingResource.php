<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class ToppingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}