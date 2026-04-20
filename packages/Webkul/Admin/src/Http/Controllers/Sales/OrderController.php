<?php

namespace Webkul\Admin\Http\Controllers\Sales;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\View\View;
use Webkul\Admin\DataGrids\Sales\OrderDataGrid;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Admin\Http\Resources\AddressResource;
use Webkul\Admin\Http\Resources\CartResource;
use Webkul\Checkout\Facades\Cart;
use Webkul\Checkout\Repositories\CartRepository;
use Webkul\Customer\Repositories\CustomerGroupRepository;
use Webkul\Sales\Repositories\OrderCommentRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Transformers\OrderResource;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderRepository $orderRepository,
        protected OrderCommentRepository $orderCommentRepository,
        protected CartRepository $cartRepository,
        protected CustomerGroupRepository $customerGroupRepository,
        protected OrderItemRepository $orderItemRepository,
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        if (request()->ajax()) {
            return datagrid(OrderDataGrid::class)->process();
        }

        $channels = core()->getAllChannels();

        $groups = $this->customerGroupRepository->findWhere([['code', '<>', 'guest']]);

        return view('admin::sales.orders.index', compact('channels', 'groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(int $cartId)
    {
        $cart = $this->cartRepository->find($cartId);

        if (! $cart) {
            return redirect()->route('admin.sales.orders.index');
        }

        $addresses = AddressResource::collection($cart->customer->addresses);

        $cart = new CartResource($cart);

        return view('admin::sales.orders.create', compact('cart', 'addresses'));
    }

    /**
     * Store order
     */
    public function store(int $cartId)
    {
        $cart = $this->cartRepository->findOrFail($cartId);

        Cart::setCart($cart);

        if (Cart::hasError()) {
            return response()->json([
                'message' => trans('admin::app.sales.orders.create.error'),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        Cart::collectTotals();

        try {
            $this->validateOrder();
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $cart = Cart::getCart();

        if (! in_array($cart->payment->method, ['cashondelivery', 'moneytransfer'])) {
            return response()->json([
                'message' => trans('admin::app.sales.orders.create.payment-not-supported'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = (new OrderResource($cart))->jsonSerialize();

        $order = $this->orderRepository->create($data);

        Cart::removeCart($cart);

        session()->flash('order', trans('admin::app.sales.orders.create.order-placed-success'));

        return new JsonResource([
            'redirect' => true,
            'redirect_url' => route('admin.sales.orders.view', $order->id),
        ]);
    }

    /**
     * Show the view for the specified resource.
     *
     * @return View
     */
    public function view(int $id)
    {
        $order = $this->orderRepository->findOrFail($id);

        return view('admin::sales.orders.view', compact('order'));
    }

    /**
     * Reorder action for the specified resource.
     *
     * @return Response
     */
    public function reorder(int $id)
    {
        $order = $this->orderRepository->findOrFail($id);

        $cart = Cart::createCart([
            'customer' => $order->customer,
            'is_active' => false,
        ]);

        Cart::setCart($cart);

        foreach ($order->items as $item) {
            try {
                Cart::addProduct($item->product, $item->additional);
            } catch (\Exception $e) {
                // do nothing
            }
        }

        return redirect()->route('admin.sales.orders.create', $cart->id);
    }

    /**
     * Cancel action for the specified resource.
     *
     * @return Response
     */
    public function cancel(int $id)
    {
        $order = $this->orderRepository->findOrFail($id);
        
        // Return inventory before deleting
        $this->returnInventoryForOrder($order);
        
        // Delete the order
        $order->delete();

        session()->flash('success', trans('admin::app.sales.orders.view.cancel-success'));

        return redirect()->route('admin.sales.orders.index');
    }

    /**
     * Return inventory for cancelled order.
     */
    protected function returnInventoryForOrder($order): void
    {
        \Log::info('Returning inventory for cancelled order #' . $order->id);
        
        foreach ($order->items as $item) {
            // Skip if product doesn't manage stock
            if (! $item->product || ! $item->product->manage_stock) {
                continue;
            }

            // Get the quantity to return
            $qty = $item->qty_ordered ?? ($item->parent?->qty_ordered ?? 0);

            if ($qty <= 0) {
                continue;
            }

            // Return from ordered_inventories (remove reserved quantity)
            $orderedInventory = $item->product->ordered_inventories()
                ->where('channel_id', $order->channel_id)
                ->first();

            if ($orderedInventory) {
                $newOrderedQty = max(0, $orderedInventory->qty - $qty);
                $orderedInventory->update(['qty' => $newOrderedQty]);
                \Log::info('Returned ordered_inventory qty: ' . $qty . ', new qty: ' . $newOrderedQty);
            }

            // Return to actual inventory
            $channelInventorySourceIds = $order->channel->inventory_sources->where('status', 1)->pluck('id');

            foreach ($channelInventorySourceIds as $inventorySourceId) {
                $inventory = $item->product->inventories()
                    ->where('inventory_source_id', $inventorySourceId)
                    ->first();

                if ($inventory) {
                    $inventory->update(['qty' => $inventory->qty + $qty]);
                    \Log::info('Returned to inventory source #' . $inventorySourceId . ', added: ' . $qty . ', new qty: ' . $inventory->qty);
                    break; // Only return to first available inventory source
                }
            }
        }
        
        \Log::info('Inventory return complete for cancelled order #' . $order->id);
    }

    /**
     * Add comment to the order
     *
     * @return Response
     */
    public function comment(int $id)
    {
        $validatedData = $this->validate(request(), [
            'comment' => 'required',
            'customer_notified' => 'sometimes|sometimes',
        ]);

        $validatedData['order_id'] = $id;

        Event::dispatch('sales.order.comment.create.before');

        $comment = $this->orderCommentRepository->create($validatedData);

        Event::dispatch('sales.order.comment.create.after', $comment);

        session()->flash('success', trans('admin::app.sales.orders.view.comment-success'));

        return redirect()->route('admin.sales.orders.view', $id);
    }

    /**
     * Update order status.
     *
     * @return JsonResponse
     */
    public function updateStatus(int $id)
    {
        $order = $this->orderRepository->findOrFail($id);
        
        $validated = request()->validate([
            'status' => 'required|in:pending,processing,shipped',
        ]);

        $oldStatus = $order->status;
        $newStatus = $validated['status'];

        \Log::info('Order #' . $id . ' status changing from ' . $oldStatus . ' to ' . $newStatus);

        // Reduce inventory when status changes from pending to processing or shipped
        if ($oldStatus === 'pending' && in_array($newStatus, ['processing', 'shipped'])) {
            \Log::info('Triggering inventory reduction for order #' . $id);
            $this->reduceInventoryForOrder($order);
        } else {
            \Log::info('Skipping inventory reduction - old status: ' . $oldStatus . ', new status: ' . $newStatus);
        }

        $order->status = $newStatus;
        $order->save();

        Event::dispatch('sales.order.update-status.after', $order);

        return response()->json([
            'message' => trans('admin::app.sales.orders.update-status-success'),
        ]);
    }

    /**
     * Reduce inventory for order items.
     */
    protected function reduceInventoryForOrder($order): void
    {
        \Log::info('Starting inventory reduction for order #' . $order->id);
        
        foreach ($order->items as $item) {
            \Log::info('Processing order item #' . $item->id);
            
            // Skip if product doesn't manage stock
            if (! $item->product || ! $item->product->manage_stock) {
                \Log::info('Skipping item #' . $item->id . ' - product does not manage stock');
                continue;
            }

            // Get the quantity to reduce
            $qty = $item->qty_ordered ?? ($item->parent?->qty_ordered ?? 0);

            \Log::info('Quantity to reduce: ' . $qty . ' for item #' . $item->id);

            if ($qty <= 0) {
                \Log::info('Skipping item #' . $item->id . ' - qty is 0 or less');
                continue;
            }

            // Reduce from ordered_inventories (reserved quantity)
            $orderedInventory = $item->product->ordered_inventories()
                ->where('channel_id', $order->channel_id)
                ->first();

            if ($orderedInventory) {
                $oldQty = $orderedInventory->qty;
                $newOrderedQty = max(0, $orderedInventory->qty - $qty);
                $orderedInventory->update(['qty' => $newOrderedQty]);
                \Log::info('Updated ordered_inventory from ' . $oldQty . ' to ' . $newOrderedQty);
            } else {
                \Log::info('No ordered_inventory found for product #' . $item->product_id);
            }

            // Reduce from actual inventory
            $channelInventorySourceIds = $order->channel->inventory_sources->where('status', 1)->pluck('id');
            \Log::info('Active inventory sources: ' . $channelInventorySourceIds->implode(', '));

            foreach ($channelInventorySourceIds as $inventorySourceId) {
                $inventory = $item->product->inventories()
                    ->where('inventory_source_id', $inventorySourceId)
                    ->first();

                if ($inventory && $inventory->qty > 0) {
                    $oldInventoryQty = $inventory->qty;
                    $reduceQty = min($qty, $inventory->qty);
                    $inventory->update(['qty' => $inventory->qty - $reduceQty]);
                    \Log::info('Updated inventory source #' . $inventorySourceId . ' from ' . $oldInventoryQty . ' to ' . $inventory->qty);
                    $qty -= $reduceQty;

                    if ($qty <= 0) {
                        break;
                    }
                } else {
                    \Log::info('Inventory source #' . $inventorySourceId . ' has qty: ' . ($inventory?->qty ?? 'null'));
                }
            }
        }
        
        \Log::info('Inventory reduction complete for order #' . $order->id);
    }

    /**
     * Result of search product.
     *
     * @return JsonResponse
     */
    public function search()
    {
        $orders = $this->orderRepository->scopeQuery(function ($query) {
            return $query->where('customer_email', 'like', '%'.urldecode(request()->input('query')).'%')
                ->orWhere('status', 'like', '%'.urldecode(request()->input('query')).'%')
                ->orWhere(DB::raw('CONCAT(customer_first_name, " ", customer_last_name)'), 'like', '%'.urldecode(request()->input('query')).'%')
                ->orWhere('increment_id', request()->input('query'))
                ->orderBy('created_at', 'desc');
        })->paginate(10);

        foreach ($orders as $key => $order) {
            $orders[$key]['formatted_created_at'] = core()->formatDate($order->created_at, 'd M Y');

            $orders[$key]['status_label'] = $order->status_label;

            $orders[$key]['customer_full_name'] = $order->customer_full_name;
        }

        return response()->json($orders);
    }

    /**
     * Validate order before creation.
     *
     * @return void|\Exception
     */
    public function validateOrder()
    {
        $cart = Cart::getCart();

        if (! Cart::haveMinimumOrderAmount()) {
            throw new \Exception(trans('admin::app.sales.orders.create.minimum-order-error', [
                'amount' => core()->formatPrice(core()->getConfigData('sales.order_settings.minimum_order.minimum_order_amount') ?: 0),
            ]));
        }

        if (
            $cart->haveStockableItems()
            && ! $cart->shipping_address
        ) {
            throw new \Exception(trans('admin::app.sales.orders.create.check-shipping-address'));
        }

        if (! $cart->billing_address) {
            throw new \Exception(trans('admin::app.sales.orders.create.check-billing-address'));
        }

        if (
            $cart->haveStockableItems()
            && ! $cart->selected_shipping_rate
        ) {
            throw new \Exception(trans('admin::app.sales.orders.create.specify-shipping-method'));
        }

        if (! $cart->payment) {
            throw new \Exception(trans('admin::app.sales.orders.create.specify-payment-method'));
        }
    }
}
