<?php
namespace Jmlamo\DemoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Bic extends Constraint
{
    //public $message = 'Invalid BIC number : "%string%"';
    public $message = 'This is not a valid Bank Identifier Code (BIC).';
    
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}
