<?php
namespace Jmlamo\DemoBundle\Utility;

class Calculator
{
    /**
     * @var integer|float $a
     * @var integer|float $b
     * @return integer|float
     */
    public function add($a, $b)
    {
        return $a + $b;
    }
}