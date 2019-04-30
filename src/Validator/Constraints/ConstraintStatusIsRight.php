<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * Class CronstraintStatusIsRight
 * @package App\Validator\Constraints
 */
class ConstraintStatusIsRight extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'La phase du projet ne peut pas être "Terminé" si vous mettez une date de fin';

    public function validatedBy()
    {
        return \get_class($this).'Validator';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
