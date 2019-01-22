<?php

namespace Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\User\Entity\User;

/**
 * Class UserFixtures
 * @package Fixtures
 */
class UserFixtures extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setUpdatedAt()
            ->setCreatedAt()
            ->setEmail('test@test.ru')
            ->setPassword(\password_hash('123', PASSWORD_BCRYPT))
            ->setApiToken()
            ->setLastLogin()
            ->setUsername('test');

        $manager->persist($user);
        $manager->flush();
    }
}