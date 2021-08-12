<?php

declare(strict_types=1);

namespace App\Entity;

interface ShippingCalculationInterface
{
    /**
     * @return int
     */
    public function getShippingFees(): int;
}
