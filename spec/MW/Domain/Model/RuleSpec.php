<?php

namespace spec\MW\Domain\Model;

use MW\Domain\Model\Rule;
use MW\Domain\Exception\UnappliedRuleException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RuleSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            0.05,
            10,
            20
        );
    }

    function it_compute_tax()
    {
        $this->apply(100)->shouldReturn((double)5);
    }

    function it_doesnt_apply_rule_when_rp_isnt_correct()
    {
        $this->shouldThrow(UnappliedRuleException::class)
            ->during('apply', [-1]);
    }
}
