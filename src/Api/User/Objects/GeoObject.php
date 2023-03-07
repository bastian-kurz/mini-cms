<?php

declare(strict_types=1);

namespace App\Api\User\Objects;

class GeoObject
{
    private ?string $lat;

    private ?string $lng;

    public function getLat(): ?string
    {
        return $this->lat;
    }

    public function setLat(?string $lat): void
    {
        $this->lat = $lat;
    }

    public function getLng(): ?string
    {
        return $this->lng;
    }

    public function setLng(?string $lng): void
    {
        $this->lng = $lng;
    }
}
