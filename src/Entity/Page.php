<?php

namespace App\Entity;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Class Page
 * @package App\Entity
 */
class Page extends AbstractEntity
{
    /**
     * @var string guid
     */
    private $pageId;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * @var bool
     */
    private $isDefault = false;

    /**
     * @var Carbon
     */
    protected $createdAt;

    /**
     * @var Carbon
     */
    protected $updatedAt;

    /**
     * Page constructor.
     */
    public function __construct()
    {
        $this->pageId = Uuid::uuid4();
        parent::__construct();
    }

    /**
     * @return string
     */
    public function getPageId(): string
    {
        return $this->pageId;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function getIsDefault(): bool
    {
        return $this->isDefault;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return Page
     */
    public function setSlug(string $slug): Page
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @param string $title
     *
     * @return Page
     */
    public function setTitle(string $title): Page
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $content
     *
     * @return Page
     */
    public function setContent(string $content): Page
    {
        $this->content = $content;
        return $this;
    }

}