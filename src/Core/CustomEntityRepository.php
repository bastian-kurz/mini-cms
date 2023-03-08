<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Command\WriterInterface;
use App\Entity\EntityInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use RuntimeException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CustomEntityRepository implements CustomEntityRepositoryInterface
{
    private EntityManager $em;

    private string $class;

    private EntityRepository $entityRepository;

    private SerializerInterface $serializer;

    private ValidatorInterface $validator;

    private WriterInterface $writer;

    public function __construct(
        EntityManager $em,
        string $class,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        WriterInterface $writer
    ) {
        $this->em = $em;
        $this->class = $class;
        $this->entityRepository = $this->em->getRepository($class);
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->writer = $writer;
    }

    public function read(?array $payload, ?int $id): iterable|EntityInterface
    {
        if ($payload !== null) {
            //@ToDo implement pagination
            return $this->entityRepository->findBy($payload);
        }

        $entity = $this->entityRepository->find($id);
        if ($entity === null) {
            throw new NotFoundHttpException(sprintf("Entity %s with id: %d not found!", $this->class, $id));
        }

        if (!$entity instanceof EntityInterface) {
            throw new RuntimeException('Return value of read is not an EntityInterface!');
        }
        return $entity;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function delete(int $id): void
    {
        $entity = $this->read(null, $id);
        $this->em->remove($entity);
        $this->em->flush();
    }

    public function create(array $payload): int
    {
        if ($this->isCollection($payload)) {
            throw new BadRequestException(
                'Only single write operations are supported.Please send the entities one by one.'
            );
        }

        $entity = $this->serializer->deserialize(json_encode($payload), $this->class, 'json');
        $this->validate($entity);

        return $this->writer->write($entity, $this->em);
    }

    public function update(array $payload, int $id): int
    {
        $entity = $this->read(null, $id);
        $entity = $this->serializer->deserialize(json_encode($payload), $this->class, 'json', ['object_to_populate' => $entity]);
        $this->validate($entity);
        return $this->writer->write($entity, $this->em);
    }

    private function isCollection(array $payload): bool
    {
        return array_keys($payload) === range(0, count($payload) - 1);
    }

    private function validate(EntityInterface $entity): void
    {
        $errors = $this->validator->validate($entity);

        if (count($errors) > 0) {
            throw new BadRequestException($errors->__toString());
        }
    }
}
