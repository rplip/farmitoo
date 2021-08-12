<?php

declare(strict_types=1);

namespace App\Updater;

use App\Calculator\PriceCalculator;
use App\Calculator\SalesCalculator;
use App\Entity\Order;
use App\Entity\Promotion;

class PromoUpdater
{
    /**
     * @param Order   $order
     * @param Product $promotion
     */
    public function addPromotion(Order $order, Promotion $promotion)
    {
        $order->addPromotion($promotion);

        $salesCalculator = new SalesCalculator();

        $sales = $salesCalculator->calculate($order);
        $order->setPromotionReduction($sales);
    }
}
