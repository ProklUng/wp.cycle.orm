<?php

namespace Prokl\WpCycleOrmBundle\Entities;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;

/**
 * Class Comment
 * @package Prokl\WpCycleOrmBundle\Entities
 *
 * @since 07.04.2021
 *
 * @Entity
 */
class Comment
{
    /**
     * @Column(type="primary")
     * @var int
     */
    protected $comment_ID;

    /**
     * Comment constructor.
     */
    public function __construct()
    {

    }
}
