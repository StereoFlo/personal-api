<?php

namespace App\Repository;

use App\Entity\ApiToken;
use App\Entity\User;

/**
 * Interface UserInterface
 * @package App\Repository
 */
interface UserInterface
{
    /**
     * @param User $user
     *
     * @return User
     */
    public function save(User $user): UserRepository ;

    /**
     * @param ApiToken $apiToken
     *
     * @return User|null
     */
    public function getByToken(ApiToken $apiToken): ?User ;

    /**
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email): ?User ;

}