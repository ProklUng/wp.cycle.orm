<?php

namespace Prokl\WpCycleOrmBundle\Contracts;

use Spiral\Database\Config\DatabaseConfig;

/**
 * Interface DatabaseConfiguratorInterface
 * @package Prokl\WpCycleOrmBundle\Contracts
 *
 * @since 16.06.2021
 */
interface DatabaseConfiguratorInterface
{
    /**
     * Конфигурация БД.
     *
     * @return DatabaseConfig
     */
    public function getDatabaseConfig(): DatabaseConfig;
}