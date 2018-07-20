<?php

namespace App\Repository\Page;

use App\Entity\Page;

/**
 * Interface PageWriteInterface
 * @package App\Repository\Page
 */
interface PageWriteInterface
{
    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function save(Page $page): PageRepository ;

    /**
     * @param Page $page
     *
     * @return PageRepository
     */
    public function delete(Page $page): PageRepository ;
}