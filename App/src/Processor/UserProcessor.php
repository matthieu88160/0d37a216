<?php

declare(strict_types=1);

namespace App\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\UnitOfWork;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly EntityManagerInterface $manager
    ) {
    }

    /**
     * @param User $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $data->setPassword($this->passwordHasher->hashPassword($data, $data->getPassword()));

        if ($this->manager->getUnitOfWork()->getEntityState($data) !== UnitOfWork::STATE_MANAGED) {
            $this->manager->persist($data);
        }

        $this->manager->flush();

        return $data;
    }
}
