<?php

namespace App\Validator;

use App\Service\PhoneNumberFilter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PhoneNumberValidator extends ConstraintValidator
{
    private PhoneNumberFilter $filter;

    /**
     * PhoneNumberValidator constructor.
     */
    public function __construct(PhoneNumberFilter $filter)
    {
        $this->filter = $filter;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var PhoneNumber $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if ($this->filter->filter($value)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
