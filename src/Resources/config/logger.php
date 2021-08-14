<?php
/**
 * Spiral Database Bundle
 *
 * @author Vlad Shashkov <root@myaza.info>
 * @copyright Copyright (c) 2021, The Myaza Software
 */

declare(strict_types=1);

use Prokl\WpCycleOrmBundle\DataCollector\SpiralDatabaseCollector;
use Prokl\WpCycleOrmBundle\QueryAnalyzer\QueryAnalyzer;
use Prokl\WpCycleOrmBundle\Twig\QueryFormatterExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\param;
use function Symfony\Component\DependencyInjection\Loader\Configurator\tagged_iterator;

return static function (ContainerConfigurator $di): void {
    $services = $di->services();

    $services

        ->set('spiral.database.collector', SpiralDatabaseCollector::class)
        ->args([
            tagged_iterator('spiral.query_logger'),
            param('cycle_orm.config'),
        ])
        ->tag('data_collector', [
            'id' => 'spiral.database',
        ])

        ->set('spiral.query_analyzer', QueryAnalyzer::class)

        ->set('spiral.query_formatter.extension', QueryFormatterExtension::class)
        ->tag('twig.extension')
    ;
};
