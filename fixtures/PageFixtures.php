<?php

namespace Fixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Domain\Page\Entity\Page;

/**
 * Class PageFixtures
 * @package Fixtures
 */
class PageFixtures extends Fixture
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
        $page = new Page();
        $page->setCreatedAt()
            ->setUpdatedAt()
            ->setIsDefault(true)
            ->setSlug('test')
            ->setContent('контент тестовой страници')
            ->setTitle('тестовая страница')
            ->setShowInMenu(true);

        $manager->persist($page);
        $manager->flush();
        $page = null;

        $page = new Page();
        $page->setCreatedAt()
            ->setUpdatedAt()
            ->setIsDefault(false)
            ->setSlug('test1')
            ->setContent('контент второй тестовой страницы')
            ->setTitle('тестовая страница1')
            ->setShowInMenu(true);

        $manager->persist($page);
        $manager->flush();
        $parentId = $page->getPageId();
        $page = null;

        $page = new Page();
        $page->setCreatedAt()
            ->setUpdatedAt()
            ->setIsDefault(false)
            ->setSlug('test1')
            ->setContent('контент третьей тестовой страницы')
            ->setTitle('тестовая страница1')
            ->setShowInMenu(true)
            ->setParentPageId($parentId);

        $manager->persist($page);
        $manager->flush();

    }
}