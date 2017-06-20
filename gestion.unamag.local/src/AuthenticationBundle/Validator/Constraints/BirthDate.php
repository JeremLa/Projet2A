<?php

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class BirthDate extends Constraint
{
    public $message = 'La date {{ date }} n\'a pas un format valide ( jj/mm/yyyy ) ou n\'est pas valide';

}