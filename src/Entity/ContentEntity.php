<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[ORM\Table(name: 'content')]
#[ORM\HasLifecycleCallbacks]
class ContentEntity implements EntityInterface
{
    use EntityTrait;

    #[ORM\Id]
    #[ORM\Column(type: "integer", length: 11)]
    #[ORM\GeneratedValue]
    private int $id;

    #[ORM\Column(type: "string", length: 2)]
    #[Assert\NotBlank]
    #[Assert\Length(exactly: 2)]
    private string $isoCode;

    #[ORM\Column(type: "string", length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    private string $title;

    #[ORM\Column(type: "text")]
    private string $text;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }

    public function setIsoCode(string $isoCode): void
    {
        $this->isoCode = $isoCode;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
