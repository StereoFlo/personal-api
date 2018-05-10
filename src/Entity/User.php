<?php

namespace App\Entity;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Class User
 * @package App\Entity
 */
class User
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Carbon
     */
    private $createdAt;

    /**
     * @var Carbon
     */
    private $updatedAt;

    /**
     * @var ApiToken
     */
    private $apiToken;

    /**
     * @var Roles
     */
    private $roles;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->userId = Uuid::uuid4();
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();

        $this->apiToken = new ApiToken();
        $this->roles    = new Roles();
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return Carbon
     */
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }

    /**
     * @return Carbon
     */
    public function getUpdatedAt(): Carbon
    {
        return $this->updatedAt;
    }

    /**
     * @return ApiToken
     */
    public function getApiToken(): ApiToken
    {
        return $this->apiToken;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return Roles
     */
    public function getRoles(): Roles
    {
        return $this->roles;
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @param string $password
     *
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return User
     */
    public function setCreatedAt(): User
    {
        $this->createdAt = Carbon::now();
        return $this;
    }

    /**
     * @return User
     */
    public function setUpdatedAt(): User
    {
        $this->updatedAt = Carbon::now();
        return $this;
    }


}