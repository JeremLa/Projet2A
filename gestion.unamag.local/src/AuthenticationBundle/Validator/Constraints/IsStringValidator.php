<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 19/06/2017
 * Time: 13:39
 */

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsStringValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $pattern = "/^[a-zA-Z]*$/";
        if(!preg_match($pattern, $value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}