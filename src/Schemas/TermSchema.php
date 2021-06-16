<?php

namespace Prokl\WpCycleOrmBundle\Schemas;

use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Prokl\WpCycleOrmBundle\Contracts\AbstractCycleSchema;
use Prokl\WpCycleOrmBundle\Entities\Taxonomy;
use Prokl\WpCycleOrmBundle\Entities\Term;

/**
 * Class TermSchema
 * @package Prokl\WpCycleOrmBundle\Schemas
 *
 * @since 07.04.2021
 */
class TermSchema extends AbstractCycleSchema
{
    protected $table = 'terms';

    protected $entityClass = Term::class;

    /**
     * @inheritDoc
     */
    public function schema() : array
    {
        return [
            $this->entityClass => [
                Schema::MAPPER      => $this->mapperClass,
                Schema::ENTITY      => $this->entityClass,
                Schema::DATABASE    => $this->database,
                Schema::TABLE       => $this->table,
                Schema::PRIMARY_KEY => 'term_id',
                Schema::COLUMNS     => [
                    'term_id'   => 'term_id',  // property => column
                    'name' => 'name',
                    'slug' => 'slug',
                    'group' => 'term_group',
                ],
                Schema::TYPECAST    => [
                    'term_id' => 'int',

                ],
                Schema::RELATIONS   => [
                    'taxonomy' => [
                        Relation::TYPE   => Relation::HAS_MANY,
                        Relation::TARGET => Taxonomy::class,
                        Relation::SCHEMA => [
                            Relation::CASCADE   => true,
                            Relation::OUTER_KEY => 'term',
                            Relation::INNER_KEY => 'term_id',
                        ],
                    ],
                ]
            ]
        ];
    }
}
