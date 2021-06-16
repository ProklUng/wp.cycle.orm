<?php

namespace Prokl\WpCycleOrmBundle\Entities;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Post
 * @package Prokl\WpCycleOrmBundle\Entities
 *
 * @since 06.04.2021
 *
 * @Entity
 */
class Post
{
    /**
     * @Column(type="primary")
     * @var int
     */
    protected $id;

    /**
     * @Column(name="post_type",type="string")
     * @var string
     */
    protected $type;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $guid;

    /**
     *
     * @Column(name="post_date", type="datetime", nullable=false)
     */
    protected $date;

    /**
     *
     * @Column(name="post_date_gmt", type="datetime", nullable=false)
     */
    protected $dateGmt;

    /**
     *
     * @Column(name="post_content", type="text", nullable=false)
     */
    protected $content;

    /**
     *
     * @Column(name="post_title", type="text", nullable=false)
     */
    protected $title;

    /**
     * @Column(name="post_excerpt", type="text", nullable=false)
     */
    protected $excerpt;

    /**
     *
     * @Column(name="post_status", type="string(20)", nullable=false)
     */
    protected $status = "publish";

    /**
     *
     * @Column(name="comment_status", type="string(20)", nullable=false)
     */
    protected $commentStatus = "open";

    /**
     *
     * @Column(name="ping_status", type="string(20)", nullable=false)
     */
    protected $pingStatus = "open";

    /**
     *
     * @Column(name="post_password", type="string(20)", nullable=false)
     */
    protected $password = "";

    /**
     * @Column(name="post_name", type="string(200)", nullable=false)
     */
    protected $slug;

    /**
     * @Column(name="to_ping", type="text", nullable=false)
     */
    protected $toPing = "";

    /**
     * @Column(name="pinged", type="text", nullable=false)
     */
    protected $pinged = "";

    /**
     * @Column(name="post_modified", type="datetime", nullable=false)
     */
    protected $modifiedDate;

    /**
     * @Column(name="post_modified_gmt", type="datetime", nullable=false)
     */
    protected $modifiedDateGmt;

    /**
     * @Column(name="post_content_filtered", type="text", nullable=false)
     */
    protected $contentFiltered = "";

    /**
     *
     * @Column(name="menu_order", type="integer", length=11, nullable=false)
     */
    protected $menuOrder = 0;

    /**
     * @Column(name="post_mime_type", type="string(100)", nullable=false)
     */
    protected $mimeType = "";

    /**
     * @Column(name="comment_count", type="bigint", nullable=false)
     */
    protected $commentCount = 0;

    /**
     * @Column(name="post_parent", type="bigint")
     */
    protected $parent;

    /**
     *
     * @HasMany(target="PostMeta")
     * @var PostMeta|null
     */
    protected $metas;

    /**
     * @HasMany(target="Taxonomy")
     */
    protected $taxonomies;

    /**
     * @HasMany(target="Comment")
     */
    protected $comments;

    /**
     * @Column(name="post_author", type="integer")
     */
    protected $author;

    /**
     * @HasOne(target="User")
     */
    protected $user;

    /**
     *
     * @HasMany (target="Post")
     */
    protected $post_parent;

    /**
     * @HasMany(target="Post")
     */
    protected $children;

     /**
     * Post constructor.
     */
    public function __construct()
    {
        $this->metas      = new ArrayCollection();
        $this->comments   = new ArrayCollection();
        $this->taxonomies = new ArrayCollection();
        $this->children   = new ArrayCollection();
        $this->parent     = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getPostParent()
    {
        return $this->post_parent;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children): void
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getTaxonomies()
    {
        return $this->taxonomies;
    }

    /**
     * @param mixed $taxonomies
     */
    public function setTaxonomies($taxonomies): void
    {
        $this->taxonomies = $taxonomies;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getGuid(): string
    {
        return $this->guid;
    }

    /**
     * @param string $guid
     */
    public function setGuid(string $guid): void
    {
        $this->guid = $guid;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getDateGmt()
    {
        return $this->dateGmt;
    }

    /**
     * @param mixed $dateGmt
     */
    public function setDateGmt($dateGmt): void
    {
        $this->dateGmt = $dateGmt;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * @param mixed $excerpt
     */
    public function setExcerpt($excerpt): void
    {
        $this->excerpt = $excerpt;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCommentStatus(): string
    {
        return $this->commentStatus;
    }

    /**
     * @param string $commentStatus
     */
    public function setCommentStatus(string $commentStatus): void
    {
        $this->commentStatus = $commentStatus;
    }

    /**
     * @return string
     */
    public function getPingStatus(): string
    {
        return $this->pingStatus;
    }

    /**
     * @param string $pingStatus
     */
    public function setPingStatus(string $pingStatus): void
    {
        $this->pingStatus = $pingStatus;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return string
     */
    public function getToPing(): string
    {
        return $this->toPing;
    }

    /**
     * @param string $toPing
     */
    public function setToPing(string $toPing): void
    {
        $this->toPing = $toPing;
    }

    /**
     * @return string
     */
    public function getPinged(): string
    {
        return $this->pinged;
    }

    /**
     * @param string $pinged
     */
    public function setPinged(string $pinged): void
    {
        $this->pinged = $pinged;
    }

    /**
     * @return mixed
     */
    public function getModifiedDate()
    {
        return $this->modifiedDate;
    }

    /**
     * @param mixed $modifiedDate
     */
    public function setModifiedDate($modifiedDate): void
    {
        $this->modifiedDate = $modifiedDate;
    }

    /**
     * @return mixed
     */
    public function getModifiedDateGmt()
    {
        return $this->modifiedDateGmt;
    }

    /**
     * @param mixed $modifiedDateGmt
     */
    public function setModifiedDateGmt($modifiedDateGmt): void
    {
        $this->modifiedDateGmt = $modifiedDateGmt;
    }

    /**
     * @return string
     */
    public function getContentFiltered(): string
    {
        return $this->contentFiltered;
    }

    /**
     * @param string $contentFiltered
     */
    public function setContentFiltered(string $contentFiltered): void
    {
        $this->contentFiltered = $contentFiltered;
    }

    /**
     * @return int
     */
    public function getMenuOrder(): int
    {
        return $this->menuOrder;
    }

    /**
     * @param int $menuOrder
     */
    public function setMenuOrder(int $menuOrder): void
    {
        $this->menuOrder = $menuOrder;
    }

    /**
     * @return string
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @param string $mimeType
     */
    public function setMimeType(string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @return int
     */
    public function getCommentCount(): int
    {
        return $this->commentCount;
    }

    /**
     * @param int $commentCount
     */
    public function setCommentCount(int $commentCount): void
    {
        $this->commentCount = $commentCount;
    }

    /**
     * @return mixed
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * @param PostMeta|null $metas
     */
    public function setMetas(?PostMeta $metas): void
    {
        $this->metas = $metas;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

}
