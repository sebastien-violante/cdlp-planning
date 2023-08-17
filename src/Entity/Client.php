<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $firstname = null;

    #[ORM\Column(length: 1)]
    private ?string $initial = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $departureDate = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $adults = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $children = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column]
    private ?bool $cleaned = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $red = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $green = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $blue = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getInitial(): ?string
    {
        return $this->initial;
    }

    public function setInitial(string $initial): static
    {
        $this->initial = $initial;

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(\DateTimeInterface $arrivalDate): static
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(\DateTimeInterface $departureDate): static
    {
        $this->departureDate = $departureDate;

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

    public function getAdults(): ?int
    {
        return $this->adults;
    }

    public function setAdults(?int $adults): static
    {
        $this->adults = $adults;

        return $this;
    }

    public function getChildren(): ?int
    {
        return $this->children;
    }

    public function setChildren(?int $children): static
    {
        $this->children = $children;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function isCleaned(): ?bool
    {
        return $this->cleaned;
    }

    public function setCleaned(bool $cleaned): static
    {
        $this->cleaned = $cleaned;

        return $this;
    }

    public function getRed(): ?int
    {
        return $this->red;
    }

    public function setRed(?int $red): static
    {
        $this->red = $red;

        return $this;
    }

    public function getGreen(): ?int
    {
        return $this->green;
    }

    public function setGreen(?int $green): static
    {
        $this->green = $green;

        return $this;
    }

    public function getBlue(): ?int
    {
        return $this->blue;
    }

    public function setBlue(?int $blue): static
    {
        $this->blue = $blue;

        return $this;
    }
}
