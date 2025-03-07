<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TransportOrderRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Enum\LoadType;
use App\Enum\Currency;
use App\Enum\TransportOrderStatus;

#[ORM\Entity(repositoryClass: TransportOrderRepository::class)]
#[Gedmo\SoftDeleteable(fieldName: 'deletedAt', timeAware: false)]
#[ORM\Table(name: "transport_orders")]
class TransportOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $fromStreet;

    #[ORM\Column(type: "string", length: 10)]
    private string $fromPostalCode;

    #[ORM\Column(type: "string", length: 100)]
    private string $fromCity;

    #[ORM\Column(type: "string", length: 100)]
    private string $fromCountry;

    #[ORM\Column(type: "string", length: 255)]
    private string $toStreet;

    #[ORM\Column(type: "string", length: 10)]
    private string $toPostalCode;

    #[ORM\Column(type: "string", length: 100)]
    private string $toCity;

    #[ORM\Column(type: "string", length: 100)]
    private string $toCountry;

    #[ORM\Column(type: "string", enumType: LoadType::class)]
    private LoadType $loadType;

    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    #[Assert\GreaterThan(0)]
    private float $price;

    #[ORM\Column(type: "string", enumType: Currency::class)]
    private Currency $currency;

    #[ORM\Column(type: "string", length: 255)]
    private string $companyName;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $companyNip = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $companyStreet;

    #[ORM\Column(type: "string", length: 10)]
    private string $companyPostalCode;

    #[ORM\Column(type: "string", length: 100)]
    private string $companyCity;

    #[ORM\Column(type: "string", length: 100)]
    private string $companyCountry;

    #[ORM\Column(type: "string", length: 100, nullable: true)]
    private ?string $companyContactPerson = null;

    #[ORM\Column(type: "string", length: 50, nullable: true)]
    #[Assert\Email]
    private ?string $companyEmail = null;

    #[ORM\Column(type: "string", length: 20, nullable: true)]
    private ?string $companyPhone = null;

    #[ORM\Column(type: "string", enumType: TransportOrderStatus::class)]
    private TransportOrderStatus $status;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $notes = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $loadingDateTime = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $unloadingDateTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $orderNumber = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deletedAt = null;

    #[ORM\ManyToOne]
    private ?User $deletedBy = null;

    #[ORM\ManyToOne(inversedBy: 'transportOrders')]
    private ?Reservation $reservation = null;

    public function __toString(): string
    {
        return $this->orderNumber;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFromStreet(): string
    {
        return $this->fromStreet;
    }

    public function setFromStreet(?string $fromStreet): self
    {
        $this->fromStreet = $fromStreet;
        return $this;
    }

    public function getFromPostalCode(): ?string
    {
        return $this->fromPostalCode;
    }

    public function setFromPostalCode(?string $fromPostalCode): self
    {
        $this->fromPostalCode = $fromPostalCode;
        return $this;
    }

    public function getFromCity(): ?string
    {
        return $this->fromCity;
    }

    public function setFromCity(?string $fromCity): self
    {
        $this->fromCity = $fromCity;
        return $this;
    }

    public function getFromCountry(): ?string
    {
        return $this->fromCountry;
    }

    public function setFromCountry(?string $fromCountry): self
    {
        $this->fromCountry = $fromCountry;
        return $this;
    }

    public function getToStreet(): ?string
    {
        return $this->toStreet;
    }

    public function setToStreet(?string $toStreet): self
    {
        $this->toStreet = $toStreet;
        return $this;
    }

    public function getToPostalCode(): ?string
    {
        return $this->toPostalCode;
    }

    public function setToPostalCode(?string $toPostalCode): self
    {
        $this->toPostalCode = $toPostalCode;
        return $this;
    }

    public function getToCity(): ?string
    {
        return $this->toCity;
    }

    public function setToCity(?string $toCity): self
    {
        $this->toCity = $toCity;
        return $this;
    }

    public function getToCountry(): ?string
    {
        return $this->toCountry;
    }

    public function setToCountry(?string $toCountry): self
    {
        $this->toCountry = $toCountry;
        return $this;
    }

    public function getLoadType(): ?LoadType
    {
        return $this->loadType;
    }

    public function setLoadType(?LoadType $loadType): self
    {
        $this->loadType = $loadType;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    public function setCurrency(?Currency $currency): self
    {
        $this->currency = $currency;
        return $this;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->companyName = $companyName;
        return $this;
    }

    public function getCompanyNip(): ?string
    {
        return $this->companyNip;
    }

    public function setCompanyNip(?string $companyNip): self
    {
        $this->companyNip = $companyNip;
        return $this;
    }

    public function getCompanyStreet(): ?string
    {
        return $this->companyStreet;
    }

    public function setCompanyStreet(?string $companyStreet): self
    {
        $this->companyStreet = $companyStreet;
        return $this;
    }

    public function getCompanyPostalCode(): ?string
    {
        return $this->companyPostalCode;
    }

    public function setCompanyPostalCode(?string $companyPostalCode): self
    {
        $this->companyPostalCode = $companyPostalCode;
        return $this;
    }

    public function getCompanyCity(): ?string
    {
        return $this->companyCity;
    }

    public function setCompanyCity(?string $companyCity): self
    {
        $this->companyCity = $companyCity;
        return $this;
    }

    public function getCompanyCountry(): ?string
    {
        return $this->companyCountry;
    }

    public function setCompanyCountry(?string $companyCountry): self
    {
        $this->companyCountry = $companyCountry;
        return $this;
    }

    public function getCompanyContactPerson(): ?string
    {
        return $this->companyContactPerson;
    }

    public function setCompanyContactPerson(?string $companyContactPerson): self
    {
        $this->companyContactPerson = $companyContactPerson;
        return $this;
    }

    public function getCompanyEmail(): ?string
    {
        return $this->companyEmail;
    }

    public function setCompanyEmail(?string $companyEmail): self
    {
        $this->companyEmail = $companyEmail;
        return $this;
    }

    public function getCompanyPhone(): ?string
    {
        return $this->companyPhone;
    }

    public function setCompanyPhone(?string $companyPhone): self
    {
        $this->companyPhone = $companyPhone;
        return $this;
    }


    public function getStatus(): ?TransportOrderStatus
    {
        return $this->status;
    }

    public function setStatus(?TransportOrderStatus $status): self
    {
        $this->status = $status;
        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;
        return $this;
    }

    public function getLoadingDateTime(): ?\DateTimeInterface
    {
        return $this->loadingDateTime;
    }

    public function setLoadingDateTime(?\DateTimeInterface $loadingDateTime): static
    {
        $this->loadingDateTime = $loadingDateTime;

        return $this;
    }

    public function getUnloadingDateTime(): ?\DateTimeInterface
    {
        return $this->unloadingDateTime;
    }

    public function setUnloadingDateTime(?\DateTimeInterface $unloadingDateTime): static
    {
        $this->unloadingDateTime = $unloadingDateTime;

        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(): static
    {
        $orderNumber = 'TO/';
        for( $i = strlen(strval($this->getId())); $i<5; $i++){
            $orderNumber.='0';
        }
        $orderNumber.=$this->getId().'/'.$this->getLoadType()?->value;

        $this->orderNumber = $orderNumber;

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

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }
}
