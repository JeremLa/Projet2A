<?php

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class PhoneFormat extends Constraint
{
    public $message = 'Le numéro de téléphone "{{ phone }}" n\'a pas un format valide.';
}