<?php
/**
 * Spiral Database Bundle
 *
 * @author Vlad Shashkov <root@myaza.info>
 * @copyright Copyright (c) 2021, The Myaza Software
 */

declare(strict_types=1);

namespace Prokl\WpCycleOrmBundle\Logger;

use Prokl\WpCycleOrmBundle\QueryAnalyzer\QueryAnalyzer;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Contracts\Service\ResetInterface;

/**
 * @internal Fork from https://github.com/Myaza-Software/SprialDatabaseBundle
 */
final class QueryLogger extends AbstractLogger implements ResetInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var Dump
     */
    private $dump;

    /**
     * @var QueryAnalyzer
     */
    private $queryAnalyzer;

    /**
     * QueryLogger constructor.
     */
    public function __construct(string $connection, QueryAnalyzer $queryAnalyzer, ?LoggerInterface $logger = null)
    {
        $this->queryAnalyzer = $queryAnalyzer;
        $this->dump          = new Dump($connection);
        $this->logger        = $logger ?? new NullLogger();
    }

    /**
     * @param array<string,mixed> $context
     */
    public function log($level, $message, array $context = []): void
    {
        $analysis = $this->queryAnalyzer->analyze($message, $context);

        if (!$analysis->hasQuery()) {
            $this->logger->log($level, $message, $context);

            return;
        }

        $query = $analysis->getQuery();

        if ($query->isWrite()) {
            $this->dump->incrementWriteQuery();
        } else {
            $this->dump->incrementReadQuery();
        }

        $this->dump->addQuery($query);

        $this->logger->log($level, $message, $context);
    }

    public function dump(): Dump
    {
        return $this->dump;
    }

    public function reset(): void
    {
        $this->dump = $this->dump->withConnection();
    }
}
