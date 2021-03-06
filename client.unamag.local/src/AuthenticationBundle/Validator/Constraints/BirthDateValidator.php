<?php

namespace AuthenticationBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\VarDumper\VarDumper;

class BirthDateValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        $pattern = "/^[0-3][0-9]\/[0-1][0-9]\/\d{4}$/";

            if (preg_match($pattern, $value)) {
                list($dd, $mm, $yyyy) = explode('/', $value);
                if (!checkdate($mm, $dd, $yyyy)) {
                    $this->context->buildViolation($constraint->message)
                        ->setParameter('{{ date }}', $value)
                        ->addViolation();
                }
            }else{
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ date }}', $value)
                    ->addViolation();
            }



    }
}