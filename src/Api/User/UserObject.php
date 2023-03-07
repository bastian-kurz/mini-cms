<?php

declare(strict_types=1);

namespace App\Api\User;

use App\Api\User\Objects\AddressObject;
use App\Api\User\Objects\CompanyObject;

class UserObject
{
    private ?int $id;

    private ?string $name;

    private ?string $userName;

    private ?string $email;

    private ?AddressObject $address;

    private ?string $phone;

    private ?string $website;

    private ?CompanyObject $company;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(?string $userName): void
    {
        $this->userName = $userName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): void
    {
        $this->website = $website;
    }

    public function getAddress(): ?AddressObject
    {
        return $this->address;
    }

    public function setAddress(?AddressObject $address): void
    {
        $this->address = $address;
    }

    public function getCompany(): ?CompanyObject
    {
        return $this->company;
    }

    public function setCompany(?CompanyObject $company): void
    {
        $this->company = $company;
    }
}
