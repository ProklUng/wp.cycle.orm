<?php

namespace Prokl\WpCycleOrmBundle\Services\Bootstrap;

use Prokl\WpCycleOrmBundle\Contracts\DatabaseConfiguratorInterface;
use Spiral\Database\Config\DatabaseConfig;

/**
 * Class DatabaseConfigurator
 * @package Prokl\WpCycleOrmBundle\Services\Bootstrap
 *
 * @since 16.06.2021
 */
class DatabaseConfigurator implements DatabaseConfiguratorInterface
{
    /**
     * @var DatabaseConfig $databaseConfig Конфигурация баз данных.
     */
    private $databaseConfig;

    /**
     * DatabaseConfigInitializer constructor.
     *
     * @param array  $config     Конфигурация баз данных.
     * @param string $connection Название соединения.
     */
    public function __construct(array $config, string $connection = '')
    {
        $database = $connection ?: $config['default_connection'];

        $this->databaseConfig = new DatabaseConfig([
            'default'     => $database,
            'databases'   => $config['databases'],
            'connections' => $config['connections']
        ]);
    }

    /**
     * @inheritDoc
     */
    public function getDatabaseConfig(): DatabaseConfig
    {
        return $this->databaseConfig;
    }
}