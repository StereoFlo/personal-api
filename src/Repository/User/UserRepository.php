<?php

namespace App\Repository\User;

use App\Entity\ApiToken;
use App\Entity\User;
use App\Repository\SharedRepository;

/**
 * Class UserRepository
 * @package App\Repository
 */
class UserRepository extends SharedRepository implements UserReadInterface, UserWriteInterface
{
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