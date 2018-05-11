<?php

namespace App\Repository\Page;

use App\Entity\Page;

/**
 * Interface PageInterface
 * @package App\Repository\Page
 */
interface PageInterface
{
    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function save(Page $page): PageRepository ;

    /**
     * @param string $slug
     *
     * @return Page|null
     */
    public function getBySlug(string $slug): ?Page ;

    /**
     * @return Page|null
     */
    public function getDefaultPage(): ?Page ;
}