<?php

namespace Repository\Page;

use Doctrine\ORM\QueryBuilder;
use Entity\Page;
use Repository\AbstractRepository;

/**
 * Class PageRepository
 * @package Repository\Page
 */
class PageRepository extends AbstractRepository implements PageWriteInterface, PageReadInterface
{
    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function save(Page $page): PageRepository
    {
        $this->saveItem($page);

        return $this;
    }

    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function delete(Page $page): PageRepository
    {
        $this->removeItem($page);

        return $this;
    }

    /**
     * @param string $slug
     *
     * @return Page|null
     */
    public function getBySlug(string $slug): ?Page
    {
        return $this->getRepository(Page::class)->findOneBy(['slug' => $slug]);
    }

    /**
     * @param string $pageId
     *
     * @return Page|null
     */
    public function getById(string $pageId): ?Page
    {
        return $this->getRepository(Page::class)->find($pageId);
    }

    /**
     * @return Page|null
     */
    public function getDefaultPage(): ?Page
    {
        return $this->getRepository(Page::class)->findOneBy(['isDefault' => true]);
    }

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Page[]|null
     */
    public function getList(int $limit = 10, int $offset = 0): ?array
    {
        return $items = $this->getQueryForList()
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return int
     */
    public function getCountForList(): int
    {
        $items = $this->getQueryForList()
            ->getQuery()
            ->getResult();

        return \count($items);
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryForList(): QueryBuilder
    {
        return $this->getQueryBuilder()
            ->select('page')
            ->from(Page::class, 'page');
    }
}