<?php

namespace App\Repository;

use App\Entity\ApiToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository implements UserInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    /**
     * UserRepository constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param User $user
     *
     * @return User
     */
    public function save(User $user): UserRepository
    {
        $this->manager->persist($user);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param ApiToken $apiToken
     *
     * @return User|null
     */
    public function getByToken(ApiToken $apiToken): ?User
    {
        return $this->manager
            ->getRepository(User::class)
            ->findOneBy(['apiToken.key' => $apiToken->getKey()]);
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        return $this->manager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }
}