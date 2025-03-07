<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: VehicleRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
class Vehicle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $licenseNumber = null;

    #[ORM\Column(nullable: true)]
    private ?float $mileage = null;


    #[ORM\Column]
    private ?int $yearOfProduction = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $vehicleIdentificationNumber = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $purchaseDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $firstRegisterDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $salesDate = null;

    #[ORM\ManyToOne(inversedBy: 'vehicles')]
    private ?User $caretaker = null;

    #[ORM\Column(length: 255)]
    private ?string $fuelType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $mileageDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\ManyToOne]
    private ?User $deletedBy = null;

    public function __toString(): string
    {
        return  $this->getLicenseNumber();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(string $licenseNumber): static
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    public function getMileage(): ?float
    {
        return $this->mileage;
    }

    public function setMileage(?float $mileage): static
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getYearOfProduction(): ?int
    {
        return $this->yearOfProduction;
    }

    public function setYearOfProduction(int $yearOfProduction): static
    {
        $this->yearOfProduction = $yearOfProduction;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getVehicleIdentificationNumber(): ?string
    {
        return $this->vehicleIdentificationNumber;
    }

    public function setVehicleIdentificationNumber(string $vehicleIdentificationNumber): static
    {
        $this->vehicleIdentificationNumber = $vehicleIdentificationNumber;

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

    public function getFirstRegisterDate(): ?\DateTimeInterface
    {
        return $this->firstRegisterDate;
    }

    public function setFirstRegisterDate(?\DateTimeInterface $firstRegisterDate): static
    {
        $this->firstRegisterDate = $firstRegisterDate;

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

    public function getFuelType(): ?string
    {
        return $this->fuelType;
    }

    public function setFuelType(string $fuelType): static
    {
        $this->fuelType = $fuelType;

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
}
