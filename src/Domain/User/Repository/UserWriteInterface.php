<?php

namespace Domain\User\Repository;

use Domain\User\Entity\User;

/**
 * Interface UserWriteInterface
 * @package Repository\User
 */
interface UserWriteInterface
{
    /**
     * @param User $user
     *
     * @return User
     */
    public function save(User $user): User ;
}