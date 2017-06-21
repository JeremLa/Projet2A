<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 19/06/2017
 * Time: 11:33
 */

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PhoneFormatValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $pattern1 = "/^(0|\+33|0033)[1-9]([-][0-9]{2}){4}$/";
        $pattern2 = "/^(0|\+33|0033)[1-9]([.][0-9]{2}){4}$/";
        $pattern3 = "/^(0|\+33|0033)[1-9]([0-9]{2}){4}$/";
        $pattern4 = "/^(0|\+33|0033)[1-9]([' '][0-9]{2}){4}$/";

        $patterns = [$pattern1, $pattern2, $pattern3, $pattern4];

        $bool = false;

        foreach ($patterns as $pattern){
            if(preg_match($pattern, $value)){
               $bool = true;

               break;
            }
        }

        if(!$bool){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ phone }}', $value)
                ->addViolation();
        }
    }
}