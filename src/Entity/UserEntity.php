<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserEntityRepository::class)]
#[ORM\Table(name: 'user')]
class User
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: "integer", length: 11)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "string", length: 256)]
    private string $email;

    #[ORM\Column(type: "string", length: 60)]
    private string $password;

    #[ORM\Column(type: "string", length: 128, nullable: true)]
    private ?string $secret;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $scopes;

    #[ORM\Column(type: "boolean")]
    private bool $active;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getSecret(): ?string
    {
        return $this->secret;
    }

    public function setSecret(?string $secret): void
    {
        $this->secret = $secret;
    }

    public function getScopes(): ?string
    {
        return $this->scopes;
    }

    public function setScopes(?string $scopes): void
    {
        $this->scopes = $scopes;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }
}
