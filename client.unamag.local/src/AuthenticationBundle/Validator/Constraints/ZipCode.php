<?php
/**
 * Created by PhpStorm.
 * User: Jérémy
 * Date: 19/06/2017
 * Time: 13:25
 */

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class ZipCode extends Constraint
{
    public $message = 'Le code postal {{ zipCode }} n\'a pas un format valide.';
}