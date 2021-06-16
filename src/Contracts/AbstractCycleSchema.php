<?php

namespace Prokl\WpCycleOrmBundle\Contracts;

use Cycle\ORM\Mapper\Mapper;

/**
 * Class AbstractCycleSchema
 * @package Prokl\WpCycleOrmBundle\Contracts
 *
 * @since 07.04.2021
 */
abstract class AbstractCycleSchema implements CycleSchemaInterface
{
    /**
     * @var string $database Название соединения с БД.
     */
    protected $database = 'default';

    /**
     * @var string $table Таблица.
     */
    protected $table = '';

    /**
     * @var string $entityClass Класс сущности.
     */
    protected $entityClass = '';

    /**
     * @var string $mapperClass Mapper.
     */
    protected $mapperClass = Mapper::class;

    /**
     * @inheritDoc
     */
    abstract public function schema() : array;
}
