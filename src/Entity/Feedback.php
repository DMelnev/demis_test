<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use App\Validator\PhoneNumber;
use App\Validator\UniquePhoneNumber;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FeedbackRepository::class)
 */
class Feedback
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Поле должно быть заполнено!")
     * @Assert\Length(max=200, maxMessage="Не более 200 символов!")
     */
    private ?string $fullName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max=250, maxMessage="Не более 250 символов!")
     */
    private ?string $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Поле должно быть заполнено!")
     * @PhoneNumber(message="Номер указан не корректно!")
     * @UniquePhoneNumber(message="Вы уже отправляли запрос")
     */
    private ?string $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Email(message="Email введен не корректно")
     */
    private ?string $email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $this->clearPhoneNumber($phoneNumber);

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function clearPhoneNumber(?string $number): ?string
    {
        if (!$number) return null;
        $phone = preg_replace('/[^0-9]/', '', $number);
        if (strlen($phone) == 10 && $phone[0] == '9') $phone = '7' . $phone;
        if (strlen($phone) == 11 && $phone[0] == '8') $phone[0] = '7';
        return $phone;
    }
}
