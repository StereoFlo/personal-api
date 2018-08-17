<?php

namespace Repository\Page;

use Entity\Page;

/**
 * Interface PageReadInterface
 * @package Repository\Page
 */
interface PageReadInterface
{
    /**
     * @param string $slug
     *
     * @return Page|null
     */
    public function getBySlug(string $slug): ?Page ;

    /**
     * @param string $pageId
     *
     * @return Page|null
     */
    public function getById(string $pageId): ?Page ;

    /**
     * @return Page|null
     */
    public function getDefaultPage(): ?Page ;

    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Page[]|null
     */
    public function getList(int $limit = 10, int $offset = 0): ?array ;

    /**
     * @return int
     */
    public function getCountForList(): int ;
}