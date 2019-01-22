<?php

namespace Domain\Page\Repository;

use Doctrine\ORM\QueryBuilder;
use Domain\Page\Entity\Page;
use Domain\Shared\Repository\AbstractRepository;

/**
 * Class PageRepository
 * @package Repository\Page
 */
class PageRepository extends AbstractRepository implements PageWriteInterface, PageReadInterface
{
    /**
     * @param Page $page
     *
     * @return Page|null
     */
    public function save(Page $page): ?Page
    {
        $this->saveItem($page);

        return $page;
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
     * @return Page|null|object
     */
    public function getBySlug(string $slug): ?Page
    {
        return $this->getRepository()->findOneBy(['slug' => $slug]);
    }

    /**
     * @param string $pageId
     *
     * @return Page|null|object
     */
    public function getById(string $pageId): ?Page
    {
        return $this->getRepository()->find($pageId);
    }

    /**
     * @return Page|null|object
     */
    public function getDefaultPage(): ?Page
    {
        return $this->getRepository()->findOneBy(['isDefault' => true]);
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
     * @return string
     */
    protected function getEntity(): string
    {
        return Page::class;
    }

    /**
     * @return QueryBuilder
     */
    private function getQueryForList(): QueryBuilder
    {
        return $this->getQueryBuilder()
            ->select('page')
            ->from($this->getEntity(), 'page');
    }
}