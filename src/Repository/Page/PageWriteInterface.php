<?php

namespace Repository\Page;

use Entity\Page;

/**
 * Interface PageWriteInterface
 * @package Repository\Page
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