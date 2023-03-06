<?php

declare(strict_types=1);

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "refresh_token")]
class RefreshToken
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: "integer", length: 11)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "integer", length: 11)]
    private int $userId;

    #[ORM\Column(type: "string", length: 255)]
    private string $tokenId;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $issuedAt;

    #[ORM\Column(type: "datetime_immutable")]
    private DateTimeImmutable $expiresAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getTokenId(): string
    {
        return $this->tokenId;
    }

    public function setTokenId(string $tokenId): void
    {
        $this->tokenId = $tokenId;
    }

    public function getIssuedAt(): DateTimeImmutable
    {
        return $this->issuedAt;
    }

    public function setIssuedAt(DateTimeImmutable $issuedAt): void
    {
        $this->issuedAt = $issuedAt;
    }

    public function getExpiresAt(): DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(DateTimeImmutable $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }
}
