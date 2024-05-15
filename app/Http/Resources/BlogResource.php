<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
class BlogResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'article' => $this->article,
            'created_at' => $this->created_at,
            'image' => asset('bloguploadimg/' . $this->image),
        ];
    }
}