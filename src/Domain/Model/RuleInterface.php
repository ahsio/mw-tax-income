<?php

namespace MW\Domain\Model;

use MW\Domain\Exception\UnappliedRuleException;

interface RuleInterface
{
    /**
     * @param float $rp
     *
     * @return float
     *
     * @throws UnappliedRuleException
     */
    public function apply($rp);
}
