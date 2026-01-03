<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'image_url'                   => $this->formatImageUrls($this->image_url),
            'first_image'                 => $this->getFirstImage($this->image_url),
            'description'                 => $this->description,
            'price'                       => (float) $this->price,
            'discount_price_percent'      => $this->calculateDiscountPercent(),
            'discount_price'              => (float) $this->discount_price,
            'display_price'               => $this->discount_price > 0 ? (float) $this->discount_price : (float) $this->price,
            'has_discount'                => $this->discount_price > 0 && $this->discount_price < $this->price,
            'stock'                       => $this->stock,
            'size'                        => $this->size,
        ];
    }

    /**
     * Format image URLs to include storage path
     */
    private function formatImageUrls($imageUrl): array
    {
        if (!$imageUrl) {
            return ['https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&h=400&fit=crop'];
        }

        // If it's already an array
        if (is_array($imageUrl)) {
            return array_map(function ($path) {
                return $this->formatSingleImageUrl($path);
            }, $imageUrl);
        }

        // If it's a JSON string, decode it
        if (is_string($imageUrl)) {
            $decoded = json_decode($imageUrl, true);
            if (is_array($decoded)) {
                return array_map(function ($path) {
                    return $this->formatSingleImageUrl($path);
                }, $decoded);
            }
            // If it's just a single path string
            return [$this->formatSingleImageUrl($imageUrl)];
        }

        return ['https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&h=400&fit=crop'];
    }

    /**
     * Format a single image URL
     */
    private function formatSingleImageUrl($path): string
    {
        if (!$path) {
            return 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&h=400&fit=crop';
        }

        // If already a full URL, return as is
        if (str_starts_with($path, 'http') || str_starts_with($path, '/')) {
            return $path;
        }

        // Otherwise prepend /storage/
        return '/storage/' . $path;
    }

    /**
     * Get the first image from the image URLs
     */
    private function getFirstImage($imageUrl): string
    {
        $images = $this->formatImageUrls($imageUrl);
        return $images[0] ?? 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=400&h=400&fit=crop';
    }

    /**
     * Calculate discount percentage
     */
    private function calculateDiscountPercent(): float
    {
        if (!$this->discount_price || $this->discount_price >= $this->price) {
            return 0.0;
        }

        return round((($this->price - $this->discount_price) / $this->price) * 100, 2);
    }
}
