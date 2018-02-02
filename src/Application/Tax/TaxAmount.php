<?php

namespace MW\Application\Tax;

use MW\Application\Tax\RuleSet;
use MW\Application\Exception\UnableToCalculateTaxIncomeException;
use MW\Domain\Exception\UnappliedRuleException;

class TaxAmount implements TaxAmountInterface
{
    /** @var RuleSet */
    private $ruleSet;

    /**
     * @param RuleSet $ruleSet
     */
    public function __construct(RuleSet $ruleSet)
    {
        $this->ruleSet = $ruleSet;
    }

    /**
     * @param float $rp
     * @return float
     *
     * @throws UnableToCalculateTaxIncomeException
     */
    public function calculate($rp)
    {
        $tax = 0;

        foreach ($this->ruleSet->getRules() as $rule) {
            $incomePortion =  $rp - $rule->getFrom();
            if ($incomePortion < 0) {
                continue;
            }

            try {
                $tax += $rule->apply($incomePortion);    
            } catch (UnappliedRuleException $e) {
                // @todo log here the lower level exception before throwing the upper level one
                throw new UnableToCalculateTaxIncomeException($incomePortion, $e);
            }
            
            $rp -= $incomePortion;
        }

        return $tax;
    }
}
