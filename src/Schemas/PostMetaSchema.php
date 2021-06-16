<?php

namespace Prokl\WpCycleOrmBundle\Schemas;

use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Prokl\WpCycleOrmBundle\Contracts\AbstractCycleSchema;
use Prokl\WpCycleOrmBundle\Entities\Post;
use Prokl\WpCycleOrmBundle\Entities\PostMeta;

/**
 * Class PostMetaSchema
 * @package Prokl\WpCycleOrmBundle\Schemas
 *
 * @since 06.04.2021
 */
class PostMetaSchema extends AbstractCycleSchema
{
    protected $table = 'postmeta';

    protected $entityClass = PostMeta::class;

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
                Schema::PRIMARY_KEY => 'meta_id',
                Schema::COLUMNS     => [
                    'id'   => 'meta_id',  // property => column
                    'key' => 'meta_key',
                    'value' => 'meta_value',
                ],
                Schema::TYPECAST    => [
                    'meta_id' => 'int',

                ],
                Schema::RELATIONS   => [
                    'post' => [
                        Relation::TYPE   => Relation::HAS_ONE,
                        Relation::TARGET => Post::class,
                        Relation::SCHEMA => [
                            Relation::CASCADE   => true,
                            Relation::INNER_KEY => 'id',
                            Relation::OUTER_KEY => 'id',
                        ],
                    ]
                ]
            ]
        ];
    }
}
