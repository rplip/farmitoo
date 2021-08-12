<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\Order;

class PriceCalculator
{
    /**
     * @param Order $order
     *
     * @return int
     */
    public function calculate(Order $order): int
    {
        $items = $order->getItems();
        $priceOrder = 0;
        foreach ($items as $item) {
            $price = $item->getProduct()->getPrice();
            $totalPrice = $item->getQuantity()*$price;
            $priceOrder += $totalPrice;
        }

        return $priceOrder;
    }
}
