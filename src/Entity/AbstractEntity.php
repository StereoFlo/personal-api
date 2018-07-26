<?php

namespace Entity;

use Carbon\Carbon;

/**
 * Class AbstractEntity
 * @package Entity
 */
abstract class AbstractEntity
{
    /**
     * @var Carbon
     */
    protected $createdAt;

    /**
     * @var Carbon
     */
    protected $updatedAt;

    /**
     * AbstractEntity constructor.
     */
    public function __construct()
    {
        $this->createdAt = Carbon::now();
        $this->updatedAt = Carbon::now();
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
     * @param Carbon $createdAt
     * @param bool   $forceNull
     *
     * @return AbstractEntity
     */
    public function setCreatedAt(Carbon $createdAt = null, bool $forceNull = false): ?self
    {
        if ($forceNull) {
            return null;
        }

        if (empty($createdAt) && !$forceNull) {
            $this->createdAt = Carbon::now();
            return $this;
        }

        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @param Carbon $updatedAt
     *
     * @param bool   $forceNull
     *
     * @return self|null
     */
    public function setUpdatedAt(Carbon $updatedAt = null, bool $forceNull = false): ?self
    {
        if ($forceNull) {
            return null;
        }

        if (empty($updatedAt) && !$forceNull) {
            $this->updatedAt = Carbon::now();
            return $this;
        }

        $this->updatedAt = $updatedAt;
        return $this;
    }

}