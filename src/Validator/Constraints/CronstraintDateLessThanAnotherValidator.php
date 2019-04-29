<?php


namespace App\Validator\Constraints;

use App\Entity\Project;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class CronstraintDateLessThanAnotherValidator extends ConstraintValidator
{
    /**
     * @param Project $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof CronstraintDateLessThanAnother) {
            throw new UnexpectedTypeException($constraint, CronstraintDateLessThanAnother::class);
        }
        if (null === $value || '' === $value) {
            return;
        }
        if($value->getEndedAt() != null && $value->getStartedAt()>$value->getEndedAt()){
            $this->context->buildViolation($constraint->message)
                ->atPath('endedAt')
                ->addViolation();
        }
    }
}