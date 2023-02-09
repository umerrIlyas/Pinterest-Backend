<?php

namespace App\Http\Resources;

use App\Models\Post;
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
            'title' => $this->title,
            'description' => $this->description,
            'file' => $this->is_default ? $this->file : asset(Post::PATH . $this->file),

            'is_liked' => $this->when($this->likes, function () {
                return $this->likes()->where('user_id', 1)->where('post_id', $this->id)->exists();
            }),

            'totalLikes' => $this->likes->count(),
            'user' => $this->user,
        ];
    }
}
