<?php

namespace Repository\User;

use Entity\ApiToken;
use Entity\User;

/**
 * Interface UserReadInterface
 * @package Repository\User
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