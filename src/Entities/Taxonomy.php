<?php

namespace Prokl\WpCycleOrmBundle\Entities;

use Cycle\Annotated\Annotation\Entity;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Relation\HasMany;
use Cycle\Annotated\Annotation\Relation\ManyToMany;
use Cycle\ORM\Promise\Collection\CollectionPromise;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Taxonomy
 * @package Prokl\WpCycleOrmBundle\Entities
 *
 * @since 06.04.2021
 *
 * @Entity
 */
class Taxonomy
{
    /**
     * @Column(type="primary")
     * @var int
     */
    protected $term_id;

    /**
     * @Column(name="taxonomy", type="string(32)")
     */
    protected $name;

    /**
     * @Column(name="description", type="text")
     */
    protected $description = '';

    /**
     * @Column(name="parent", type="bigint(20)")
     */
    protected $parent;

    /**
     * @Column(name="count", type="bigint(20)")
     */
    protected $count = 0;

    /**
     * @HasMany (target="Term")
     */
    protected $term;

    /**
     * Taxonomy constructor.
     */
    public function __construct()
    {
        $this->term = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getTermId(): int
    {
        return $this->term_id;
    }

    /**
     * @param int $term_id
     */
    public function setTermId(int $term_id): void
    {
        $this->term_id = $term_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
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
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count): void
    {
        $this->count = $count;
    }

    /**
     * @return mixed
     */
    public function getTerm()
    {
        return $this->term;
    }

    /**
     * @param mixed $term
     */
    public function setTerm($term): void
    {
        $this->term = $term;
    }
}
