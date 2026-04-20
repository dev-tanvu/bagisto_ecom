<?php

namespace Webkul\Admin\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Shop\Models\FlashSaleItem;
use Webkul\Shop\Repositories\FlashSaleItemRepository;

class FlashSaleController extends Controller
{
    public function __construct(
        protected FlashSaleItemRepository $flashSaleItemRepository
    ) {}

    /**
     * Get flash sale items.
     */
    public function index(): JsonResponse
    {
        $items = $this->flashSaleItemRepository
            ->getModel()
            ->with('product')
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->map(function ($item) {
                $item->image_url = $item->image_path
                    ? (function_exists('cloudinary_url') ? cloudinary_url($item->image_path) : asset('storage/'.$item->image_path))
                    : null;
                $item->product_name = $item->product?->name ?? null;

                return $item;
            });

        return response()->json([
            'data' => $items,
        ]);
    }

    /**
     * Store flash sale item.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ]);

        $data = $request->only([
            'title',
            'subtitle',
            'link',
            'product_id',
            'sort_order',
            'status',
        ]);

        // Set channel_id
        $data['channel_id'] = core()->getCurrentChannel()->id;

        // Cast status
        if (isset($data['status'])) {
            $data['status'] = filter_var($data['status'], FILTER_VALIDATE_BOOLEAN);
        }

        $item = $this->flashSaleItemRepository->create($data);

        return response()->json([
            'data' => $item,
            'message' => 'Flash sale item created successfully.',
        ]);
    }

    /**
     * Update flash sale item.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $item = $this->flashSaleItemRepository->find($id);

        if (! $item) {
            return response()->json(['message' => 'Flash sale item not found.'], 404);
        }

        $data = $request->only([
            'title',
            'subtitle',
            'link',
            'product_id',
            'sort_order',
            'status',
        ]);

        // Handle image upload
        if ($request->hasFile('image_file')) {
            $request->validate([
                'image_file' => 'file|max:10240',
            ]);

            $file = $request->file('image_file');

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

        return response()->json([
            'message' => 'Flash sale item updated successfully.',
        ]);
    }

    /**
     * Delete flash sale item.
     */
    public function destroy(int $id): JsonResponse
    {
        $item = $this->flashSaleItemRepository->find($id);

        if (! $item) {
            return response()->json([
                'message' => 'Flash sale item not found',
            ], 404);
        }

        // Delete image
        if ($item->image_path) {
            Storage::disk(config('filesystems.default'))->delete($item->image_path);
        }

        $this->flashSaleItemRepository->delete($id);

        return response()->json([
            'message' => 'Flash sale item deleted successfully.',
        ]);
    }

    /**
     * Toggle item status.
     */
    public function toggleStatus(int $id): JsonResponse
    {
        $item = $this->flashSaleItemRepository->find($id);

        if (! $item) {
            return response()->json([
                'message' => 'Flash sale item not found',
            ], 404);
        }

        $this->flashSaleItemRepository->update([
            'status' => ! $item->status,
        ], $id);

        return response()->json([
            'message' => 'Flash sale item status toggled successfully.',
            'status' => ! $item->status,
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
