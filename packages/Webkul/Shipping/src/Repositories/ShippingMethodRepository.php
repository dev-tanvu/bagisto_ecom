<?php

namespace Webkul\Shipping\Repositories;

use Webkul\Core\Eloquent\Repository;

class ShippingMethodRepository extends Repository
{
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return 'Webkul\Shipping\Models\ShippingMethod';
    }

    /**
     * Get active shipping methods.
     */
    public function getActiveMethods()
    {
        return $this->model
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get();
    }
}
