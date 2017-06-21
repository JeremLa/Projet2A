<?php
namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class ValidMail extends Constraint
{
    public $message = 'Le mail "{{ mail }}" n\'a pas un format valide.';
}