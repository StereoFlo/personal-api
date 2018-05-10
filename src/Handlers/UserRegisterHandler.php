<?php

namespace App\Handlers;

use App\Commands\UserRegisterCommand;
use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Class UserRegister
 * @package App\Handlers
 */
class UserRegisterHandler
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserRegisterHandler constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param UserRegisterCommand $command
     */
    public function handle(UserRegisterCommand $command)
    {
        $user = new User();
        $user->setEmail($command->getEmail())
            ->setUsername($command->getUsername())
            ->setPassword(\password_hash($command->getPassword(), PASSWORD_BCRYPT))
            ->setCreatedAt()
            ->setUpdatedAt();
        $this->userRepository->save($user);
    }
}