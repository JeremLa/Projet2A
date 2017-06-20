<?php
namespace AuthenticationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ValidMailValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $pattern = "/^([a-zA-Z0-9\.-_])*[a-zA-Z0-9]+@[a-zA-Z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        $constraint->groups[] = 'registration';
        if(!preg_match($pattern, $value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ mail }}', $value)
                ->addViolation();
        }
    }
}