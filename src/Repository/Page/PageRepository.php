<?php

namespace App\Repository\Page;

use App\Entity\Page;
use App\Repository\SharedRepository;

/**
 * Class PageRepository
 * @package App\Repository\Page
 */
class PageRepository extends SharedRepository implements PageWriteInterface, PageReadInterface
{
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