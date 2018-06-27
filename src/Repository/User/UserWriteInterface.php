<?php

namespace App\Repository\User;

use App\Entity\User;

/**
 * Interface UserWriteInterface
 * @package App\Repository\User
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