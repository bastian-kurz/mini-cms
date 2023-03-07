<?php declare(strict_types=1);

namespace App\Api\User\Objects;

class AddressObject
{
    private ?string $street;

    private ?string $suite;

    private ?string $city;

    private ?string $zipCode;

    private ?GeoObject $geo;

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(?string $street): void
    {
        $this->street = $street;
    }

    public function getSuite(): ?string
    {
        return $this->suite;
    }

    public function setSuite(?string $suite): void
    {
        $this->suite = $suite;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): void
    {
        $this->zipCode = $zipCode;
    }

    public function getGeo(): ?GeoObject
    {
        return $this->geo;
    }

    public function setGeo(?GeoObject $geo): void
    {
        $this->geo = $geo;
    }
}