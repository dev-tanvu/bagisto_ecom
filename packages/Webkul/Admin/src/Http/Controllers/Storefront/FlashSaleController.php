<?php

namespace Webkul\Admin\Http\Controllers\Storefront;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Shop\Repositories\FlashSaleItemRepository;

class FlashSaleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        public FlashSaleItemRepository $flashSaleItemRepository,
        public ProductRepository $productRepository
    ) {}

    /**
     * Display the flash sale management page.
     */
    public function index(): View
    {
        $channelId = core()->getRequestedChannel()->id;

        $items = $this->flashSaleItemRepository->findWhere([
            'channel_id' => $channelId,
        ], ['*'], 'sort_order')->map(function ($item) {
            $item->image_url = $item->image_path ? cloudinary_url($item->image_path) : null;
            
            // Add product name if product exists
            if ($item->product_id && $item->product) {
                $item->product_name = $item->product->name ?? 'Product #'.$item->product_id;
                $item->product_url = '/' . ($item->product->url_key ?? '');
            } else {
                $item->product_name = null;
                $item->product_url = $item->link ?? null;
            }

            return $item;
        });

        $channels = core()->getAllChannels();
        
        // Get products for dropdown (limit to 200 for performance)
        $products = $this->productRepository
            ->getModel()
            ->where('type', 'simple')
            ->orderBy('id', 'ASC')
            ->limit(200)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name ?? 'Product #'.$product->id,
                    'sku' => $product->sku,
                ];
            });

        return view('admin::storefront.flash-sale.index', compact('items', 'channels', 'channelId', 'products'));
    }

    /**
     * Store a new flash sale item.
     */
    public function store(): JsonResponse
    {
        $this->validate(request(), [
            'image_file'  => 'required|file|max:10240',
            'title'       => 'required',
            'channel_id'  => 'required|exists:channels,id',
            'product_id'  => 'nullable|exists:products,id',
        ]);

        $file = request()->file('image_file');
        $path = cloudinary_upload($file, 'flash-sale-items', null, null, true);

        $maxSortOrder = $this->flashSaleItemRepository->getModel()
            ->where('channel_id', request('channel_id'))
            ->max('sort_order');

        $item = $this->flashSaleItemRepository->create([
            'title'       => request('title'),
            'subtitle'    => request('subtitle'),
            'link'        => request('link'),
            'product_id'  => request('product_id'),
            'image_path'  => $path,
            'sort_order'  => ($maxSortOrder ?? 0) + 1,
            'status'      => 1,
            'channel_id'  => request('channel_id'),
        ]);

        return new JsonResponse([
            'message' => 'Flash sale item added successfully.',
            'item'    => $item,
        ]);
    }

    /**
     * Update an existing flash sale item.
     */
    public function update(int $id): JsonResponse
    {
        $item = $this->flashSaleItemRepository->find($id);

        if (! $item) {
            return new JsonResponse(['message' => 'Flash sale item not found.'], 404);
        }

        $data = request()->only(['title', 'subtitle', 'link', 'product_id', 'status', 'sort_order']);

        // Handle new image upload
        if (request()->hasFile('image_file')) {
            $this->validate(request(), [
                'image_file' => 'file|max:10240',
            ]);

            $file = request()->file('image_file');

            // Delete old image
            if ($item->image_path) {
                Storage::disk(config('filesystems.default'))->delete($item->image_path);
            }

            $path = cloudinary_upload($file, 'flash-sale-items', null, null, true);
            $data['image_path'] = $path;
        }

        // Cast status
        if (isset($data['status'])) {
            $data['status'] = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);
        }

        $this->flashSaleItemRepository->update($data, $id);

        return new JsonResponse([
            'message' => 'Flash sale item updated successfully.',
        ]);
    }

    /**
     * Delete a flash sale item.
     */
    public function destroy(int $id): JsonResponse
    {
        $item = $this->flashSaleItemRepository->find($id);

        if (! $item) {
            return new JsonResponse(['message' => 'Flash sale item not found.'], 404);
        }

        // Delete image file
        if ($item->image_path) {
            Storage::disk(config('filesystems.default'))->delete($item->image_path);
        }

        $this->flashSaleItemRepository->delete($id);

        return new JsonResponse([
            'message' => 'Flash sale item deleted successfully.',
        ]);
    }

    /**
     * Mass update sort orders.
     */
    public function massUpdate(): JsonResponse
    {
        $orders = request('orders', []);

        foreach ($orders as $item) {
            $this->flashSaleItemRepository->update([
                'sort_order' => $item['sort_order'],
            ], $item['id']);
        }

        return new JsonResponse([
            'message' => 'Flash sale item order updated successfully.',
        ]);
    }
}
