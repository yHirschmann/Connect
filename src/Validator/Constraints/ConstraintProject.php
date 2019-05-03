<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
    class ConstraintProject extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $statusMessage = 'La phase du projet ne peut pas être "Terminé" si vous mettez une date de fin';

    public $endDateMessage = "La date de fin d'un projet doit être supérieur à sa date de début";

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
