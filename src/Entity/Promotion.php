<?php

declare(strict_types=1);

namespace App\Entity;

class Promotion
{
    /**
     * @var string
     */
    protected string $saleBeginning;

    /**
     * @var string
     */
    protected string $saleEnding;

    /**
     * @var int
     */
    protected int $minAmount;

    /**
     * @var int
     */
    protected int $minItems;

    /**
     * @var int
     */
    protected int $reduction;

    /**
     * @param string $saleBeginning
     * @param string $saleEnding
     * @param int    $minAmount
     * @param int    $minItems
     * @param int    $reduction
     */
    public function __construct(string $saleBeginning, string $saleEnding, int $minAmount, int $minItems, int $reduction)
    {
        $this->saleBeginning = $saleBeginning;
        $this->saleEnding = $saleEnding;
        $this->minAmount = $minAmount;
        $this->minItems = $minItems;
        $this->reduction = $reduction;
    }

    /**
     * @return int
     */
    public function getSaleBeginning()
    {
        return $this->saleBeginning;
    }

    /**
     * @return int
     */
    public function getSaleEnding()
    {
        return $this->saleEnding;
    }

    /**
     * @return int
     */
    public function getMinAmount()
    {
        return $this->minAmount;
    }

    /**
     * @return int
     */
    public function getMinItems()
    {
        return $this->minItems;
    }

    /**
     * @return int
     */
    public function getReduction()
    {
        return $this->reduction;
    }
}
