<?php

namespace App\Commands;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserRegisterCommand
 * @package App\Commands
 */
class UserRegisterCommand
{
    /**
     * @Assert\NotBlank(message="Username should not be blank")
     * @var string
     */
    private $username;

    /**
     * @Assert\Email(message = "The email '{{ value }}' is not a valid email.")
     *
     * @var string
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Password should not be blank")
     *
     * @var string
     */
    private $password;

    /**
     * UserRegisterCommand constructor.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function __construct(?string $username, ?string $email, ?string $password)
    {
        $this->username = $username;
        $this->email    = $email;
        $this->password = $password;
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


}