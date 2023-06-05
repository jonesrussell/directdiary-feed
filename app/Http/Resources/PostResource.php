<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'image' => $this->image,
            'post' => $this->post,
            'file' => $this->file,
            'is_video' => $this->is_video,
            'comments' => $this->comments,
            'reposts' => $this->reposts,
            'likes' => $this->likes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
