<?php

namespace spec\MW\Application\Tax;

use MW\Application\Tax\RuleSet;
use MW\Domain\Model\Rule;
use MW\Application\Exception\UnableToCalculateTaxIncomeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TaxAmountSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            new RuleSet([['rate' => 0.05, 'range' => [0, 100]]])
        );
    }

    function it_compute_tax()
    {
        $this->calculate(100)->shouldReturn((double)5);
    }

    function it_doesnt_compute_tax_when_rp_isnt_correct()
    {
        $this->shouldThrow(UnableToCalculateTaxIncomeException::class)
            ->during('calculate', ['fake_rp']);
    }
}
