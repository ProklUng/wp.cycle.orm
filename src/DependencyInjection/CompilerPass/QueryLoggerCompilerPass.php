<?php
/**
 * Spiral Database Bundle
 *
 * @author Vlad Shashkov <root@myaza.info>
 * @copyright Copyright (c) 2021, The Myaza Software
 */

declare(strict_types=1);

namespace Prokl\WpCycleOrmBundle\DependencyInjection\CompilerPass;

use Prokl\WpCycleOrmBundle\Logger\QueryLogger;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class QueryLoggerCompilerPass
 */
final class QueryLoggerCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ('dev' !== $container->getParameter('kernel.environment')
            ||
            !$container->getParameter('cycle_orm.log_queries')
        ) {
            return;
        }

        $refMonolog     = $container->hasDefinition('monolog.logger') ? new Reference('monolog.logger') : null;
        $refQueryParser = new Reference('spiral.query_analyzer');

        $container->register(sprintf('spiral.%s.query_logger', 'logger'), QueryLogger::class)
            ->setArguments([
                'logger',
                $refQueryParser,
                $refMonolog,
            ])
            ->setPublic(true)
            ->addTag('spiral.query_logger')
            ->addTag('kernel.reset', ['method' => 'reset'])
            ->addTag('monolog.logger', ['channel' => 'spiral.dbal'])
        ;

        $refDbal = $container->getDefinition('cycle_orm.dbal');
        $refDbal->addMethodCall('setLogger', [new Reference('spiral.logger.query_logger')]);
    }
}
