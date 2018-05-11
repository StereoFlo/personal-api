<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class SharedRepository
 * @package App\Repository
 */
class SharedRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * SharedRepository constructor.
     *
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
}