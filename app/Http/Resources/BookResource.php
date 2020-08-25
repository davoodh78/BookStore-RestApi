<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) : array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'rate' => round($this->ratings->avg('rate'),1),
            'author' => new AuthorResource($this->author),
            'publisher' => new PublisherResource($this->publisher),
            'status' => $this->quantity > 0 ? 'موجود' : 'ناموجود'


        ];
    }
}
