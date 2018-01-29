<?php

namespace MW\Application\Tax;

interface TaxAmountInterface
{
    /**
     * @param float $rp
     * @return float
     */
    public function calculate($rp);
}
