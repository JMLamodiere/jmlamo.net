<?php
namespace Jmlamo\DemoBundle\Tests\Validator\Constraints;

use Jmlamo\DemoBundle\Validator\Constraints\Bic;
use Jmlamo\DemoBundle\Validator\Constraints\BicValidator;
use Symfony\Component\Validator\Validation;

class BicValidatorTest extends \Symfony\Component\Validator\Tests\Constraints\AbstractConstraintValidatorTest
{
    protected function getApiVersion()
    {
        return Validation::API_VERSION_2_5;
    }
    
    protected function createValidator()
    {
        return new BicValidator();
    }
    
    public function testNullIsValid()
    {
        $this->validator->validate(null, new Bic());
        $this->assertNoViolation();
    }
    
    public function testEmptyStringIsValid()
    {
        $this->validator->validate('', new Bic());
        $this->assertNoViolation();
    }
    
    /**
     * @dataProvider getValidBics
     */
    public function testValidBics($bic)
    {
        $this->validator->validate($bic, new Bic());
        $this->assertNoViolation();
    }
    
    public function getValidBics()
    {
        return array(
            array('DEUTDEDBDUE'), // DEUTSCHE BANK
            array('GKCCBEBB'), // DEXIA BANK SA - Bruxelles - FRANKFURT AM MAIN
            array('PSSTFRPPNTE') //La Banque postale - Centre financier de Nantes
        );
    }
    
    /**
     * @dataProvider getInvalidBics
     */
    public function testInvalidBics($bic)
    {
        $constraint = new Bic(array(
            'message' => 'myMessage',
        ));
        $this->validator->validate($bic, $constraint);
        $this->buildViolation('myMessage')
            ->setParameter('{{ value }}', '"'.$bic.'"')
            ->assertRaised();
    }
    
    public function getInvalidBics()
    {
        return array(
            array('ABCDEFG'), //7
            array('ABCDEFGHI'), //9
            array('ABCDEFGHIJ'), //10
            array('ABCDEFGHIJKL'), //12
            array('123456GHIJK'), //numbers at beguining
            array('ABCDEFGHI_K'), //underscore
            array('ABCDEFGHI K'), //space
        );
    }
}