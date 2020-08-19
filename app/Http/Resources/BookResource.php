<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use phpDocumentor\Reflection\DocBlock\Tags\Author;
use Ramsey\Uuid\Type\Integer;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->quantity > 0)
            $status = "موجود";
        else
            $status = "ناموجود";
        $a = round($this->ratings->avg('rate'),1);
        return [
          'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'rate' => $a,
            'author' => new AuthorResource($this->author),
            'publisher' => new PublisherResource($this->publisher),
            'status' =>$status


        ];
    }
}
