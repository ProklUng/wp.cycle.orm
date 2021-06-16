<?php

namespace Prokl\WpCycleOrmBundle\Schemas;

use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Prokl\WpCycleOrmBundle\Contracts\AbstractCycleSchema;
use Prokl\WpCycleOrmBundle\Entities\Post;
use Prokl\WpCycleOrmBundle\Entities\PostMeta;
use Prokl\WpCycleOrmBundle\Entities\Taxonomy;
use Prokl\WpCycleOrmBundle\Entities\User;

/**
 * Class WpPosts
 * @package Local\Services\Database\Cycle\Schemas
 *
 * @since 06.04.2021
 */
class WpPosts extends AbstractCycleSchema
{
    protected $table = 'posts';

    protected $entityClass = Post::class;

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
                Schema::PRIMARY_KEY => 'id',
                Schema::COLUMNS     => [
                    'id'   => 'id',  // property => column
                    'type' => 'post_type',
                    'guid' => 'guid',
                    'date' => 'post_date',
                    'dateGmt' => 'post_date_gmt',
                    'excerpt' => 'post_excerpt',
                    'content' => 'post_content',
                    'title' => 'post_title',
                    'status' => 'post_status',
                    'contentFiltered' => 'post_content_filtered',
                    'modifiedDateGmt' => 'post_modified_gmt',
                    'modifiedDate' => 'post_modified',
                    'pinged' => 'pinged',
                    'toPing' => 'to_ping',
                    'slug' => 'post_name',
                    'password' => 'post_password',
                    'pingStatus' => 'ping_status',
                    'commentStatus' => 'comment_status',
                    'menuOrder' => 'menu_order',
                    'commentCount' => 'comment_count',
                    'author' => 'post_author',
                    'parent' => 'post_parent',
                ],
                Schema::TYPECAST    => [
                    'id' => 'int',
                    'parent' => 'int',

                ],
                Schema::RELATIONS   => [
                    'metas' => [
                        Relation::TYPE   => Relation::HAS_MANY,
                        Relation::TARGET => PostMeta::class,
                        Relation::SCHEMA => [
                            Relation::CASCADE   => true,
                            Relation::OUTER_KEY => 'id',
                            Relation::INNER_KEY => 'id',
                        ],
                    ],
                    // Родительский пост.
                    'post_parent' => [
                        Relation::TYPE   => Relation::HAS_MANY,
                        Relation::TARGET => Post::class,
                        Relation::SCHEMA => [
                            Relation::CASCADE   => true,
                            Relation::OUTER_KEY => 'id',
                            Relation::INNER_KEY => 'parent',
                        ],
                    ],
                    // Дети - картинки итд.
                    'children' => [
                        Relation::TYPE   => Relation::HAS_MANY,
                        Relation::TARGET => Post::class,
                        Relation::SCHEMA => [
                            Relation::CASCADE   => true,
                            Relation::OUTER_KEY => 'parent',
                            Relation::INNER_KEY => 'id',
                        ],
                    ],

                    'taxonomies' => [
                        Relation::TYPE   => Relation::HAS_MANY,
                        Relation::TARGET => Taxonomy::class,
                        Relation::SCHEMA => [
                            // Relation::CASCADE   => true,
                            Relation::OUTER_KEY => 'term_id',
                            Relation::INNER_KEY => 'id',
                        ],
                    ],

                    'user' => [
                        Relation::TYPE   => Relation::HAS_ONE,
                        Relation::TARGET => User::class,
                        Relation::SCHEMA => [
                            // Relation::CASCADE   => true,
                            Relation::OUTER_KEY => 'ID',
                            Relation::INNER_KEY => 'author',
                        ],
                    ],
                ]
            ]
        ];
    }
}
