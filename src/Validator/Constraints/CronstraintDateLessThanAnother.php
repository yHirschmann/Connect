<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * Class CronstraintDateLessThanAnother
 * @package App\Validator\Constraints
 */
class CronstraintDateLessThanAnother extends Constraint
{
    public $message = "La date de fin d'un projet doit être supérieur à sa date de début";

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}