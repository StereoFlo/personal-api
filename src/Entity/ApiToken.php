<?php

namespace App\Entity;

/**
 * Class ApiToken
 * @package App\Entity
 */
class ApiToken
{
    /**
     * @var string
     */
    private $key;

    /**
     * ApiToken constructor.
     *
     * @param string|null $key
     */
    public function __construct(string $key = null)
    {
        if (empty($key)) {
            $this->key = \bin2hex(\openssl_random_pseudo_bytes(16));
            return $this;
        }

        $this->key = $key;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getKey(): ?string
    {
        return $this->key;
    }

    /**
     * @param string $key
     *
     * @return ApiToken
     */
    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }
}