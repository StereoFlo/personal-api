<?php

namespace App\Entity;

/**
 * Class Roles
 * @package App\Entity
 */
class Roles
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_MODERATOR = 'ROLE_MODERATOR';

    //ROLE_USER - для бесправного неподтверждённого пользователя
    const MAPPING = [
        'user'      => self::ROLE_USER,
        'admin'     => self::ROLE_ADMIN,
        'moderator' => self::ROLE_MODERATOR,
    ];

    /**
     * @var array
     */
    private $list = [];

    /**
     * Roles constructor.
     *
     * @param string $role
     */
    public function __construct(string $role = 'user')
    {
        $this->list[] = self::MAPPING[$role];
    }

    /**
     * @param string $role
     *
     * @return $this
     */
    public function addRole(string $role): self
    {
        if (\array_key_exists($role, self::MAPPING) && !\in_array(self::MAPPING[$role], $this->list)) {
            $this->list[] = self::MAPPING[$role];
        }
        return $this;
    }

    /**
     * @param string $role
     *
     * @return $this
     */
    public function removeRole(string $role)
    {
        if (\in_array(self::MAPPING[$role], $this->list)) {
            \array_splice($this->list, \array_search(self::MAPPING[$role], $this->list), 1);
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }

}