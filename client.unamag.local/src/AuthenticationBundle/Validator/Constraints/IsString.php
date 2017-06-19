<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 19/06/2017
 * Time: 13:37
 */

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class IsString extends Constraint
{
    public $message = 'Ce champ ne doit comporter que des lettres, {{ string }} n\'est pas valide';
}