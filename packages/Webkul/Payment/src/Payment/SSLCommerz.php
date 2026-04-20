<?php

namespace Webkul\Payment\Payment;

class SSLCommerz extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'sslcommerz';

    /**
     * Get redirect url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        // TODO: Integrate SSLCommerz API
        return route('shop.checkout.onepage.success');
    }

    /**
     * Is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        if (! $this->cart) {
            $this->setCart();
        }

        return $this->getConfigData('active');
    }
}
