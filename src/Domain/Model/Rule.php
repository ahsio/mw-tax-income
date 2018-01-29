<?php

namespace MW\Domain\Model;

use MW\Domain\Exception\UnappliedRuleException;

class Rule implements RuleInterface
{
    /** @var int */
    private $from;

    /** @var int */
    private $to;

    /** @var float */
    private $rate;

    /**
     * @param float $rate
     * @param int   $from
     * @param int   $to
     */
    public function __construct($rate, $from, $to = INF)
    {
        $this->rate = $rate;
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return int
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * {@inheritdoc}
     */
    public function apply($rp)
    {
        if ($rp <= 0) {
            throw new UnappliedRuleException($rp);
        }

        return $rp * $this->rate;
    }
}
