<?php

namespace MW\Domain\Exception;

class UnappliedRuleException extends \Exception
{
    /** @var float */
    private $rp;

    /**
     * @param float  $rp
     * @param \Exception $previous
     * @param string $message
     */
    public function __construct($rp, $previous = null, $message = "unable to apply rule")
    {
        $this->rp = $rp;

        parent::__construct($message, 0, $previous);
    }

    /**
     * @return float
     */
    public function getRp()
    {
        return $this->rp;
    }
}
