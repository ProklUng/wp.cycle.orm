<?php

namespace Prokl\WpCycleOrmBundle\Entities;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\Annotated\Annotation\Relation\HasOne;
use Cycle\Annotated\Annotation\Relation\ManyToMany;
use Cycle\ORM\Promise\Collection\CollectionPromise;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class User
 * @package Prokl\WpCycleOrmBundle\Entities
 *
 * @since 07.04.2021
 *
 * @Entity
 */
class User
{
    /**
     *
     *
     * @Column(type="primary")
     * @var int
     */
    protected $ID;

    /**
     * @Column(name="user_login", type="string(60)")
     */
    protected $username;

    /**
     *
     * @Column(name="user_pass", type="string(64)")
     */
    protected $password;

    /**
     *
     *
     * @Column(name="user_nicename", type="string(64)")
     */
    protected $nicename;

    /**
     * @Column(name="user_email", type="string(100)")
     */
    protected $email;

    /**
     * @Column(name="user_url", type="string(100)", length=100)
     */
    protected $url = '';

    /**
     * @Column(name="user_registered", type="datetime")
     */
    protected $registeredDate;

    /**
     * @Column(name="user_activation_key", type="string(60)")
     */
    protected $activationKey = '';

    /**
     * @Column(name="user_status", type="int")
     */
    protected $status = 0;

    /**
     *
     * @Column(name="display_name", type="string(250)")
     */
    protected $displayName;

    /**
     */
    protected $metas;

    /**
     */
    protected $posts;

    /**
     */
    protected $comments;

    /**
     * User constructor.
     */
    public function __construct()
    {

    }
}
