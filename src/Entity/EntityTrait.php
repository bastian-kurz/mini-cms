<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait EntityTrait
{
    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $updatedAt;

    #[ORM\Column(type: "string", length: 32)]
    private string $updater;

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getUpdater(): string
    {
        return $this->updater;
    }

    public function setUpdater(string $updater): void
    {
        $this->updater = $updater;
    }
}
