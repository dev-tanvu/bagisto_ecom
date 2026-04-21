<?php

namespace Webkul\Shop\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Webkul\Product\Helpers\Review;

class ProductResource extends JsonResource
{
    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @return void
     */
    public function __construct($resource)
    {
        $this->reviewHelper = app(Review::class);

        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param  Request
     * @return array
     */
    public function toArray($request)
    {
        $productTypeInstance = $this->getTypeInstance();

        $data = [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'url_key' => $this->url_key,
            'base_image' => product_image()->getProductBaseImage($this),
            'images' => product_image()->getGalleryImages($this),
            'is_new' => (bool) $this->new,
            'is_featured' => (bool) $this->featured,
            'on_sale' => (bool) $productTypeInstance->haveDiscount(),
            'is_saleable' => (bool) $productTypeInstance->isSaleable(),
            'is_wishlist' => (bool) auth()->guard()->user()?->wishlist_items
                ->where('channel_id', core()->getCurrentChannel()->id)
                ->where('product_id', $this->id)->count(),
            'min_price' => core()->formatPrice($productTypeInstance->getMinimalPrice()),
            'prices' => $productTypeInstance->getProductPrices(),
            'price_html' => $productTypeInstance->getPriceHtml(),
            'ratings' => [
                'average' => $this->reviewHelper->getAverageRating($this),
                'total' => $this->reviewHelper->getTotalRating($this),
            ],
            'reviews' => [
                'total' => $this->reviewHelper->getTotalReviews($this),
            ],
        ];

        // Add color swatches for configurable products (only colors used by actual variants)
        if ($this->type === 'configurable') {
            $colorMap = [
                'red'        => '#e53e3e',
                'green'      => '#38a169',
                'blue'       => '#3182ce',
                'yellow'     => '#ecc94b',
                'black'      => '#1a202c',
                'white'      => '#f7fafc',
                'pink'       => '#ed64a6',
                'purple'     => '#805ad5',
                'orange'     => '#ed8936',
                'brown'      => '#975a16',
                'grey'       => '#718096',
                'gray'       => '#718096',
                'navy'       => '#2c5282',
                'teal'       => '#2c7a7b',
                'maroon'     => '#822727',
                'beige'      => '#f5f0e8',
                'cream'      => '#fffbf0',
                'gold'       => '#d4ac0d',
                'silver'     => '#a0aec0',
                'off white'  => '#f9f9f5',
                'off-white'  => '#f9f9f5',
                'light blue' => '#90cdf4',
                'dark blue'  => '#2a4365',
                'light green'=> '#9ae6b4',
                'dark green' => '#276749',
            ];

            // Collect color option IDs actually used by variants
            $usedColorIds = $this->variants->pluck('color')->filter()->unique()->values();

            $colorAttr = $this->super_attributes->where('code', 'color')->first();

            $colors = [];
            if ($colorAttr && $usedColorIds->isNotEmpty()) {
                foreach ($colorAttr->options as $option) {
                    if (! $usedColorIds->contains((string) $option->id)) {
                        continue;
                    }
                    $hex = $option->swatch_value ?: ($colorMap[strtolower($option->admin_name)] ?? null);
                    if ($hex) {
                        $colors[] = [
                            'id'         => $option->id,
                            'name'       => $option->admin_name,
                            'hex'        => $hex,
                        ];
                    }
                }
            }

            $data['color_swatches'] = $colors;
        }

        return $data;
    }
}
