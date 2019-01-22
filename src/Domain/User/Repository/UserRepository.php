<?php

namespace Domain\User\Repository;

use Domain\Shared\Repository\AbstractRepository;
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
    public function save(User $user): User
    {
        $this->saveItem($user);
        return $user;
    }

    /**
     * @param string $apiToken
     *
     * @return User|null|object
     */
    public function getByToken(string $apiToken): ?User
    {
        return $this->getRepository()
            ->findOneBy(['apiToken.key' => $apiToken]);
    }

    /**
     * @param string $email
     *
     * @return User|null|object
     */
    public function getByEmail(string $email): ?User
    {
        return $this->getRepository()
            ->findOneBy(['email' => $email]);
    }

    /**
     * @return string
     */
    protected function getEntity(): string
    {
       return User::class;
    }
}