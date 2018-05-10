<?php


namespace App\Security\Authentication;


use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CurrentUserFactory
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * CurrentUserFactory constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if (empty($this->tokenStorage->getToken())) {
            return null;
        }

        $user = $this->tokenStorage->getToken()->getUser();
        if (\is_string($user)) {
            return null;
        }
        if (empty($user->getEntity())) {
            return null;
        }
        return $user->getEntity();
    }
}