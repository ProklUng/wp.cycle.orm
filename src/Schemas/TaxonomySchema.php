<?php

namespace Prokl\WpCycleOrmBundle\Schemas;

use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Prokl\WpCycleOrmBundle\Contracts\AbstractCycleSchema;
use Prokl\WpCycleOrmBundle\Entities\Taxonomy;
use Prokl\WpCycleOrmBundle\Entities\Term;

/**
 * Class TaxonomySchema
 * @package Prokl\WpCycleOrmBundle\Schemas
 *
 * @since 06.04.2021
 */
class TaxonomySchema extends AbstractCycleSchema
{
    protected $table = 'term_taxonomy';

    protected $entityClass = Taxonomy::class;

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
                    'name' => 'taxonomy',
                    'description' => 'description',
                    'parent' => 'parent',
                    'count' => 'count',
                ],
                Schema::TYPECAST    => [
                    'term_id' => 'int',

                ],
                Schema::RELATIONS   => [
                    'term' => [
                        Relation::TYPE   => Relation::HAS_MANY,
                        Relation::TARGET => Term::class,
                        Relation::SCHEMA => [
                            Relation::CASCADE   => true,
                            Relation::OUTER_KEY => 'term_id',
                            Relation::INNER_KEY => 'term_id',
                        ],
                    ],
                ]
            ]
        ];
    }
}
