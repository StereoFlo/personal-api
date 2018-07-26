<?php

namespace Repository\Page;

use Entity\Page;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class PageRepository
 * @package Repository\Page
 */
class PageRepository implements PageWriteInterface, PageReadInterface
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

    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function save(Page $page): PageRepository
    {
        $this->manager->persist($page);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function delete(Page $page): PageRepository
    {
        $this->manager->remove($page);
        $this->manager->flush();

        return $this;
    }

    /**
     * @param string $slug
     *
     * @return Page|null
     */
    public function getBySlug(string $slug): ?Page
    {
        return $this->manager->getRepository(Page::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * @param string $pageId
     *
     * @return Page|null
     */
    public function getById(string $pageId): ?Page
    {
        return $this->manager->getRepository(Page::class)->find($pageId);
    }

    /**
     * @return Page|null
     */
    public function getDefaultPage(): ?Page
    {
        return $this->manager->getRepository(Page::class)->findOneBy(['isDefault' => true]);
    }

    /**
     * @return Page[]|null
     */
    public function getList(): ?array
    {
        return $this->manager->getRepository(Page::class)->findAll();
    }
}