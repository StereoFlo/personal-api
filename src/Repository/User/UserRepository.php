<?php

namespace Repository\User;

use Entity\ApiToken;
use Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserRepository
 * @package Repository
 */
class UserRepository implements UserReadInterface, UserWriteInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * SharedRepository constructor.
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
     * @return self
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