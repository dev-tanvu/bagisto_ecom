<?php

namespace Webkul\Payment\Payment;

class Bkash extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'bkash';

    /**
     * Get redirect url.
     *
     * @return string
     */
    public function getRedirectUrl()
    {
        // TODO: Integrate bKash API
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
