<?php

namespace Prokl\WpCycleOrmBundle\Entities;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\HasOne;

/**
 * Class Term
 * @package Prokl\WpCycleOrmBundle\Entities
 *
 * @since 07.04.2021
 *
 * @Entity
 */
class Term
{
    /**
     * @Column(type="primary")
     * @var int
     */
    protected $term_id;

    /**
     * @Column(type="string(200)")
     */
    protected $name;

    /**
     * @Column(type="string(200)")
     */
    protected $slug;

    /**
     *
     *
     * @Column(name="term_group", type="bigint")
     */
    protected $group = 0;

    /**
     * @HasOne(target="Taxonomy")
     */
    protected $taxonomy;

    /**
     */
    protected $metas;

    /**
     * Taxonomy constructor.
     */
    public function __construct()
    {

    }
}
