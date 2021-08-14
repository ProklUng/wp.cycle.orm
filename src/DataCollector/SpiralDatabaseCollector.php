<?php
/**
 * Spiral Database Bundle
 *
 * @author Vlad Shashkov <root@myaza.info>
 * @copyright Copyright (c) 2021, The Myaza Software
 */

declare(strict_types=1);

namespace Prokl\WpCycleOrmBundle\DataCollector;

use Prokl\WpCycleOrmBundle\Logger\Dump;
use Prokl\WpCycleOrmBundle\Logger\QueryLogger;
use Symfony\Bundle\FrameworkBundle\DataCollector\TemplateAwareDataCollectorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @internal Fork from https://github.com/Myaza-Software/SprialDatabaseBundle
 */
final class SpiralDatabaseCollector implements TemplateAwareDataCollectorInterface
{
    /**
     * @var array<QueryLogger>
     */
    private $queryLoggers;

    /**
     * @var array<string,mixed>
     */
    private $config;

    /**
     * SpiralDatabaseCollector constructor.
     *
     * @param \IteratorAggregate<QueryLogger> $queryLoggers
     * @param array<string,mixed>             $config
     */
    public function __construct(\IteratorAggregate $queryLoggers, array $config)
    {
        /*
         * callback not supported serialization
         */
        $this->queryLoggers = iterator_to_array($queryLoggers);
        $this->config       = $config;
    }

    public function collect(Request $request, Response $response, ?\Throwable $exception = null): void
    {
    }

    public static function getTemplate(): ?string
    {
        return '@SpiralDatabase/data_collector/layout.html.twig';
    }

    public function getName(): string
    {
        return 'spiral.database';
    }

    /**
     * @return \Generator<Dump>
     */
    public function dumps(): \Generator
    {
        foreach ($this->queryLoggers as $queryLogger) {
            yield $queryLogger->dump();
        }
    }

    public function hasConnections(): bool
    {
        return [] !== $this->queryLoggers;
    }

    public function isEmpty(): bool
    {
        foreach ($this->queryLoggers as $queryLogger) {
            if (!$queryLogger->dump()->isEmpty()) {
                return false;
            }
        }

        return true;
    }

    public function getTotalTimeRunQuery(): float
    {
        return $this->aggregateMetric(function (Dump $dump): float {
            return $dump->getTotalTimeRunQuery();
        });
    }

    public function getCountReadQuery(): int
    {
        return (int) $this->aggregateMetric(function (Dump $dump): int {
            return $dump->getCountReadQuery();
        });
    }

    public function getCountWriteQuery(): int
    {
        return (int) $this->aggregateMetric(function (Dump $dump): int {
            return $dump->getCountWriteQuery();
        });
    }

    public function getTotalCountQuery(): int
    {
        return (int) $this->aggregateMetric(function (Dump $dump): int {
            return $dump->getTotalCountQuery();
        });
    }

    /**
     * @return \Generator<array{name:string, driver: string}>
     */
    public function getConnections(): \Generator
    {
        foreach ($this->config['connections'] as $name => $connection) {
            yield ['name' => $name, 'driver' => $connection['driver']];
        }
    }

    public function reset(): void
    {
        foreach ($this->queryLoggers as $queryLogger) {
            $queryLogger->reset();
        }
    }

    /**
     * @param callable(Dump): (int|float) $callback
     */
    private function aggregateMetric(callable $callback): float
    {
        $total = 0;

        foreach ($this->queryLoggers  as $queryLogger) {
            $total += $callback($queryLogger->dump());
        }

        return $total;
    }
}
