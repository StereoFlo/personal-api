<?php

namespace Entity;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Class User
 * @package Entity
 */
class User extends AbstractEntity
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
    protected $createdAt;

    /**
     * @var Carbon
     */
    protected $updatedAt;

    /**
     * @var Carbon
     */
    private $lastLogin;

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
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();
        $this->userId = Uuid::uuid4();

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
     * @return Carbon
     */
    public function getLastLogin(): Carbon
    {
        return $this->lastLogin;
    }

    /**
     * @return User
     */
    public function setLastLogin(): User
    {
        $this->lastLogin = Carbon::now();
        return $this;
    }

    /**
     * @param bool $isLogout
     *
     * @return User
     */
    public function setApiToken(bool $isLogout = false): User
    {
        if (!$isLogout) {
            $this->apiToken = new ApiToken();
            return $this;
        }
        $this->apiToken = null;
        return $this;
    }


}