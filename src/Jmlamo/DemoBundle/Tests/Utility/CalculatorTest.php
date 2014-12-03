<?php
namespace Jmlamo\DemoBundle\Tests\Utility;

use Jmlamo\DemoBundle\Utility\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testAdd()
    {
        $calc = new Calculator();
        $result = $calc->add(30, 12);
        
        $this->assertEquals(42, $result);
    }
}