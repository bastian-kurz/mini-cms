<?php

declare(strict_types=1);

namespace App\Core\Command;

use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManager;

interface WriterInterface
{
    public function write(EntityInterface $entity, EntityManager $em): int;
}
