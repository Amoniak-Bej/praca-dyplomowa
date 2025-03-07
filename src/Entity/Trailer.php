<?php

namespace App\Entity;

use App\Repository\TrailerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: TrailerRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]

class Trailer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $licenseNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mileage = null;

    #[ORM\Column]
    private ?int $yearOfProduction = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $kind = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $purchaseDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $salesDate = null;

    #[ORM\ManyToOne]
    private ?User $caretaker = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\ManyToOne]
    private ?User $deletedBy = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $mileageDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $firstRegisterDate = null;

    public function __toString(): string
    {
        return $this->getLicenseNumber();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(?string $licenseNumber): static
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    public function getMileage(): ?string
    {
        return $this->mileage;
    }

    public function setMileage(?string $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getYearOfProduction(): ?int
    {
        return $this->yearOfProduction;
    }

    public function setYearOfProduction(?int $yearOfProduction): static
    {
        $this->yearOfProduction = $yearOfProduction;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getKind(): ?string
    {
        return $this->kind;
    }

    public function setKind(?string $kind): static
    {
        $this->kind = $kind;

        return $this;
    }

    public function getPurchaseDate(): ?\DateTimeInterface
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(?\DateTimeInterface $purchaseDate): static
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getSalesDate(): ?\DateTimeInterface
    {
        return $this->salesDate;
    }

    public function setSalesDate(?\DateTimeInterface $salesDate): static
    {
        $this->salesDate = $salesDate;

        return $this;
    }

    public function getCaretaker(): ?User
    {
        return $this->caretaker;
    }

    public function setCaretaker(?User $caretaker): static
    {
        $this->caretaker = $caretaker;

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

    public function getMileageDate(): ?\DateTimeInterface
    {
        return $this->mileageDate;
    }

    public function setMileageDate(?\DateTimeInterface $mileageDate): static
    {
        $this->mileageDate = $mileageDate;

        return $this;
    }

    public function getFirstRegisterDate(): ?\DateTimeInterface
    {
        return $this->firstRegisterDate;
    }

    public function setFirstRegisterDate(?\DateTimeInterface $firstRegisterDate): static
    {
        $this->firstRegisterDate = $firstRegisterDate;

        return $this;
    }
}
