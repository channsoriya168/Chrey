<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                          => $this->id,
            'name'                        => $this->name,  
            'slug'                        => $this->slug,
            'code'                        => $this->code,
            'image_url'                   => $this->image_url,
            'description'                 => $this->description,
            'price'                       => (float) $this->price,
            'discount_price_percent'      => (float) $this->discount_price_percent,
            'discount_price'              => (float) $this->discount_price,
            'stock'                       => $this->stock,
            'size'                        => $this->size,
        ];
    }
}
