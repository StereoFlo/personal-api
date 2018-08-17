<?php

namespace Entity;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * Class Page
 * @package Entity
 */
class Page extends AbstractEntity
{
    /**
     * @var string guid
     */
    private $pageId;

    /**
     * guid the parent page
     *
     * @var string
     */
    private $parentPageId;

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
     * @var bool
     */
    private $showInMenu = false;

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
     * @throws \Exception
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

    /**
     * @return string
     */
    public function getParentPageId(): ?string
    {
        return $this->parentPageId;
    }

    /**
     * @param string $parentPageId
     *
     * @return Page
     */
    public function setParentPageId(?string $parentPageId): Page
    {
        $this->parentPageId = $parentPageId;
        return $this;
    }

    /**
     * @param bool $showInMenu
     *
     * @return Page
     */
    public function setShowInMenu(bool $showInMenu): Page
    {
        $this->showInMenu = $showInMenu;
        return $this;
    }

    /**
     * @return bool
     */
    public function getShowInMenu(): bool
    {
        return $this->showInMenu;
    }

    /**
     * @param bool $isDefault
     *
     * @return Page
     */
    public function setIsDefault(bool $isDefault): Page
    {
        $this->isDefault = $isDefault;
        return $this;
    }

}