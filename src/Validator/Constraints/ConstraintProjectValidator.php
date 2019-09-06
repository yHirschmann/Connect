<?php

namespace App\Validator\Constraints;

use App\Entity\Project;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintProjectValidator extends ConstraintValidator
{
    /**
     * Check if project dates respect the following order :
     *      Start < End
     * Check it the entered end date and the phase are correctly set depending of the current date
     *
     * @param Project $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        $startDate = $value->getStartedAt();
        $endDate = $value->getEndedAt();
        $now = new \DateTime("now");
        $phase = $value->getPhase();

        if (!$constraint instanceof ConstraintProject) {
            throw new UnexpectedTypeException($constraint, ConstraintProject::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        /**
         * if the end date is set
         * and if the phase is not "Terminé"
         * and if the date is > current date
         * Then display endDateMessage
         */
        if($endDate != null && $phase < 4 && $endDate> $now){
            /* @var $constraint ConstraintProject*/
            $this->context->buildViolation($constraint->statusMessage)
                ->atPath("phase")
                ->addViolation();
        }
        if($endDate != null && $startDate>$endDate){
            $this->context->buildViolation($constraint->endDateMessage)
                ->atPath('endedAt')
                ->addViolation();
        }

    }
}
