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
     * Returning this route triggers the SSLCommerz hosted payment flow.
     * The SSLCommerzController will call the API and redirect to the gateway.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        return route('shop.sslcommerz.pay');
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
