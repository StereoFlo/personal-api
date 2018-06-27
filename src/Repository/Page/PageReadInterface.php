<?php

namespace App\Repository\Page;

use App\Entity\Page;

/**
 * Interface PageReadInterface
 * @package App\Repository\Page
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
     * @return Page[]|null
     */
    public function getList(): ?array ;
}