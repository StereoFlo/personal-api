<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;

/**
 * Interface UserReadInterface
 * @package Repository\User
 */
interface UserReadInterface
{
    /**
     * @param string $apiToken
     *
     * @return User|null
     */
    public function getByToken(string $apiToken): ?User ;

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User ;
}