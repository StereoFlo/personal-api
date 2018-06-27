<?php

namespace App\Repository\User;

use App\Entity\ApiToken;
use App\Entity\User;

/**
 * Interface UserReadInterface
 * @package App\Repository\User
 */
interface UserReadInterface
{
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