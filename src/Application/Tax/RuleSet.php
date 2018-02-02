<?php

namespace MW\Application\Tax;

use MW\Domain\Model\Rule;
use MW\Domain\Model\RuleInterface;

class RuleSet
{
    /** @var array */
    private $rules;

    /**
     * @param array $rules
     */
    public function __construct(array $rules = [])
    {
        $this->buildRules($rules);
    }

    /**
     * @param array $rules
     */
    private function buildRules(array $rules) {
        foreach ($rules as $rule) {
            $this->addRule(
                new Rule($rule['rate'], $rule['range'][0], $rule['range'][1])
            );
        }
    }

    /**
     * @param RuleInterface $rule
     */
    public function addRule(RuleInterface $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @return array
     */
    public function getRules()
    {
        return array_reverse($this->rules);
    }
}
