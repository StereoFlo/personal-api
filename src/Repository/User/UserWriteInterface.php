<?php

namespace Repository\User;

use Entity\User;

/**
 * Interface UserWriteInterface
 * @package Repository\User
 */
interface UserWriteInterface
{
    /**
     * @param User $user
     *
     * @return UserRepository
     */
    public function save(User $user): UserRepository ;
}