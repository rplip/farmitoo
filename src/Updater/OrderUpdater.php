<?php

declare(strict_types=1);

namespace App\Updater;

use App\Calculator\PriceCalculator;
use App\Calculator\SalesCalculator;
use App\Calculator\ShippingCalculator;
use App\Calculator\VatCalculator;
use App\Entity\Item;
use App\Entity\Order;
use App\Entity\Product;

class OrderUpdater
{
    /**
     * @var ShippingCalculator
     */
    protected ShippingCalculator $shippingCalculator;

    /**
     * @var VatCalculator
     */
    protected VatCalculator $vatCalculator;

    /**
     * @param ShippingCalculator $shippingCalculator
     * @param VatCalculator      $vatCalculator
     */
    public function __construct(ShippingCalculator $shippingCalculator, VatCalculator $vatCalculator)
    {
        $this->shippingCalculator = $shippingCalculator;
        $this->vatCalculator = $vatCalculator;
    }

    /**
     * @param Order   $order
     * @param Product $product
     * @param int     $quantity
     */
    public function addProduct(Order $order, Product $product, int $quantity)
    {
        $item = new Item($product, $quantity);
        $order->addItem($item);

        $priceCalculator = new PriceCalculator();

        $orderPrice = $priceCalculator->calculate($order);
        $shippingFees = $this->shippingCalculator->calculate($order);
        $vatPrice = $this->vatCalculator->calculate($order);

        $order->setPrice($orderPrice);
        $order->setShippingFees($shippingFees);
        $order->setVatPrice($vatPrice);
    }
}
