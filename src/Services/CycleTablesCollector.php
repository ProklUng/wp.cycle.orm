<?php

namespace Prokl\WpCycleOrmBundle\Services;

use Cycle\ORM\ORM;
use Cycle\ORM\Schema;
use Prokl\WpCycleOrmBundle\Contracts\CycleSchemaInterface;
use Traversable;

/**
 * Class CycleTablesCollector
 * @package Prokl\WpCycleOrmBundle\Services
 *
 * @since 06.04.2021
 */
class CycleTablesCollector
{
    /**
     * @var ORM $orm ORM.
     */
    private $orm;

    /**
     * @var CycleSchemaInterface[] $schemas Схемы.
     */
    private $schemas;

    /**
     * CycleTablesCollector constructor.
     *
     * @param ORM         $orm     ORM.
     * @param Traversable $schemas Схемы.
     */
    public function __construct(
        ORM $orm,
        Traversable $schemas
    ) {
        $handlers = iterator_to_array($schemas);

        $this->schemas = $handlers;
        $this->orm = $orm;

        if (count($this->schemas) > 0) {
            $this->initSchemas();
        }
    }

    /**
     * Подцепить схемы.
     *
     * @return void
     */
    public function initSchemas() : void
    {
        $collectionSchemas = [];
        foreach ($this->schemas as $schema) {
            $collectionSchemas = array_merge($collectionSchemas, $schema->schema());
        }

        $this->orm = $this->orm->withSchema(
            new Schema($collectionSchemas)
        );
    }

    /**
     * Экземпляр сконфигурированной ORM.
     *
     * @return ORM
     */
    public function getOrm(): ORM
    {
        return $this->orm;
    }
}