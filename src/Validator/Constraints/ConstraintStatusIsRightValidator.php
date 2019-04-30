<?php

namespace App\Validator\Constraints;

use App\Entity\Project;
use App\Validator\Constraints\ConstraintStatusIsRight as StatusValidator;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintStatusIsRightValidator extends ConstraintValidator
{
    /**
     * @param Project $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        $endDate = $value->getEndedAt();
        $now = new \DateTime("now");
        $phase = $value->getPhase();

        if (!$constraint instanceof CronstraintDateLessThanAnother) {
            throw new UnexpectedTypeException($constraint, CronstraintDateLessThanAnother::class);
        }
        if (null === $value || '' === $value) {
            return;
        }if($endDate != null && $phase < 4 && $endDate> $now){
            /* @var $constraint StatusValidator */
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }


    }
}
