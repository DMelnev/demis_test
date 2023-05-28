<?php

namespace App\Validator;

use App\Repository\FeedbackRepository;
use App\Service\PhoneNumberFilter;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniquePhoneNumberValidator extends ConstraintValidator
{
    private FeedbackRepository $feedbackRepository;
    private PhoneNumberFilter $numberFilter;

    /**
     * UniquePhoneNumberValidator constructor.
     */
    public function __construct(FeedbackRepository $feedbackRepository, PhoneNumberFilter $numberFilter)
    {
        $this->feedbackRepository = $feedbackRepository;
        $this->numberFilter = $numberFilter;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var UniquePhoneNumber $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if ($this->feedbackRepository->findOneBy(['phoneNumber' => $this->numberFilter->clearPhoneNumber($value)])) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }
}
