<?php
/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 22/06/2017
 * Time: 15:00
 */

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NotNullValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        if($value == null || $value == '' || empty($value) ){
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}