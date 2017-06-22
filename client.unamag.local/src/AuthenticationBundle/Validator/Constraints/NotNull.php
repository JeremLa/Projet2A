<?php
/**
 * Created by PhpStorm.
 * User: BabyRoger
 * Date: 22/06/2017
 * Time: 14:58
 */

namespace AuthenticationBundle\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

class NotNull extends  Constraint
{
    public $message = 'Ce champ ne doit pas être vide';
}
