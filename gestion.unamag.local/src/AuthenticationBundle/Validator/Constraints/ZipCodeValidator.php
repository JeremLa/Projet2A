<?php
namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ZipCodeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $pattern = "/^(([0-9][0-9])|(9[0-5]))[0-9]{3}$/";
        if(!preg_match($pattern, $value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ zipCode }}', $value)
                ->addViolation();
        }
    }
}