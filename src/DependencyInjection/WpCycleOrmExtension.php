<?php

namespace Prokl\WpCycleOrmBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class WpCycleOrmExtension
 * @package Prokl\WpCycleOrm\DependencyInjection
 *
 * @since 16.06.2021
 */
class WpCycleOrmExtension extends Extension
{
    private const DIR_CONFIG = '/../Resources/config';

    /**
     * @inheritDoc
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.self::DIR_CONFIG)
        );

        $loader->load('services.yaml');

        // Фасады подтягиваются только, если установлен соответствующий бандл.
        if (class_exists('Prokl\FacadeBundle\Services\AbstractFacade')) {
            $loader->load('facades.yaml');
        }

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['connections'] as $key => $connection) {
            $config['connections'][$key]['options']['connection'] = 'mysql:host=' . $connection['options']['host']
                                                         . ';dbname=' . $connection['options']['db_name'];
        }

        $container->setParameter('cycle_orm.config', $config);

        $container->setParameter('cycle_orm.entities_path', $config['entities_path']);
        $container->setParameter('cycle_orm.default_connection', $config['default_connection']);
        $container->setParameter('cycle_orm.databases', $config['databases']);
        $container->setParameter('cycle_orm.connections', $config['connections']);
    }

    /**
     * @inheritDoc
     */
    public function getAlias(): string
    {
        return 'wp_cycle_orm';
    }
}
