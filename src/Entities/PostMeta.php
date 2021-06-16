<?php

namespace Prokl\WpCycleOrmBundle\Entities;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\HasOne;

/**
 * Class PostMeta
 * @package Prokl\WpCycleOrmBundle\Entities
 *
 * @since 06.04.2021
 *
 * @Entity
 */
class PostMeta
{
    /**
     * @Column(type="primary")
     * @var int
     */
    protected $meta_id;

    /**
     * @Column(name="meta_key", type="string", length=255, nullable=true)
     */
    protected $key;

    /**
     * @Column(name="meta_value", type="string", nullable=true)
     */
    protected $value;

    /**
     * @HasOne(target="Post")
     */
    protected $post;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->meta_id;
    }

}
