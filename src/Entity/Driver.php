<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


#[ORM\Entity(repositoryClass: DriverRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]

class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $surname = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $pesel = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $employmentDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $terminationDate  = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\ManyToOne]
    private ?User $deletedBy = null;

    #[ORM\ManyToOne]
    private ?User $guardian = null;

    public function __toString(): string
    {
        return $this->getName().' '.$this->getSurname();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(?string $pesel): static
    {
        $this->pesel = $pesel;

        return $this;
    }

    public function getEmploymentDate(): ?\DateTimeInterface
    {
        return $this->employmentDate;
    }

    public function setEmploymentDate(?\DateTimeInterface $employmentDate): static
    {
        $this->employmentDate = $employmentDate;

        return $this;
    }

    public function getTerminationDate (): ?\DateTimeInterface
    {
        return $this->terminationDate;
    }

    public function setTerminationDate (?\DateTimeInterface $terminationDate): static
    {
        $this->terminationDate  = $terminationDate ;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeInterface $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getDeletedBy(): ?User
    {
        return $this->deletedBy;
    }

    public function setDeletedBy(?User $deletedBy): static
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    public function getGuardian(): ?User
    {
        return $this->guardian;
    }

    public function setGuardian(?User $guardian): static
    {
        $this->guardian = $guardian;

        return $this;
    }
}
