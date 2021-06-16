<?php

namespace Prokl\WpCycleOrmBundle\Contracts;

/**
 * Interface CycleSchemaInterface
 * @package Prokl\WpCycleOrmBundle\Contracts
 *
 * @since 06.04.2021
 */
interface CycleSchemaInterface
{
    /**
     * Схема.
     *
     * @return array
     */
    public function schema() : array;
}