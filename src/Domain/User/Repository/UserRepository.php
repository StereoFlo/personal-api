<?php

namespace Domain\User\Repository;

use Domain\Shared\Repository\AbstractRepository;
use Domain\User\Entity\ApiToken;
use Domain\User\Entity\User;

/**
 * Class UserRepository
 * @package Repository
 */
class UserRepository extends AbstractRepository implements UserReadInterface, UserWriteInterface
{
    /**
     * @param User $user
     *
     * @return self
     */
    public function save(User $user): UserRepository
    {
        $this->saveItem($user);

        return $this;
    }

    /**
     * @param ApiToken $apiToken
     *
     * @return User|null
     */
    public function getByToken(ApiToken $apiToken): ?User
    {
        return $this->getRepository(User::class)
            ->findOneBy(['apiToken.key' => $apiToken->getKey()]);
    }

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User
    {
        return $this->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }
}