<?php
namespace Jmlamo\DemoBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class BicValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Bic) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\Bic');
        }
        
        if (null === $value || '' === $value) {
            return;
        }
        
        if (!is_scalar($value) && !(is_object($value) && method_exists($value, '__toString'))) {
            throw new UnexpectedTypeException($value, 'string');
        }
        
        $value = (string) $value;
        
        //6 letters + 2 or 5 alphanumeric
        if (!preg_match('/^[a-zA-Z]{6}([a-zA-Z0-9]{2}|[a-zA-Z0-9]{5})$/', $value, $matches)) {

            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $this->formatValue($value))
                ->addViolation();
        }
    }
}