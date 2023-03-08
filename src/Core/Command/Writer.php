<?php

declare(strict_types=1);

namespace App\Core\Command;

use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class Writer implements WriterInterface
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function write(EntityInterface $entity, EntityManager $em): int
    {
        $em->persist($entity);
        $em->flush();

        return $entity->getId();
    }
}
