<?php

namespace Domain\Shared\Repository;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

/**
 * Class AbstractRepository
 * @package Repository
 */
class AbstractRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected static $manager;

    /**
     * SharedRepository constructor.
     *
     * @param EntityManagerInterface $manager
     */
    final public function __construct(EntityManagerInterface $manager)
    {
        self::$manager = $manager;
    }

    /**
     * @param string $className
     *
     * @return ObjectRepository
     */
    final protected function getRepository(string $className): ObjectRepository
    {
        return self::$manager->getRepository($className);
    }

    /**
     * @return QueryBuilder
     */
    final protected function getQueryBuilder(): QueryBuilder
    {
        return self::$manager->createQueryBuilder();
    }

    /**
     * @param mixed|object $object
     */
    final protected function saveItem($object): void
    {
        self::$manager->persist($object);
        self::$manager->flush();
    }

    /**
     * @param array $objects
     */
    final protected function saveItems(array $objects): void
    {
        foreach ($objects as $object) {
            self::$manager->persist($object);
        }
        self::$manager->flush();
    }

    /**
     * @param mixed|object $object
     */
    final protected function removeItem($object): void
    {
        self::$manager->remove($object);
        self::$manager->flush();
    }

    /**
     * @param array $objects
     */
    final protected function removeItems(array $objects): void
    {
        foreach ($objects as $object) {
            self::$manager->remove($object);
        }
        self::$manager->flush();
    }
}