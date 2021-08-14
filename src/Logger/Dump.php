<?php
/**
 * Spiral Database Bundle
 *
 * @author Vlad Shashkov <root@myaza.info>
 * @copyright Copyright (c) 2021, The Myaza Software
 */

declare(strict_types=1);

namespace Prokl\WpCycleOrmBundle\Logger;

/**
 * @internal Fork from https://github.com/Myaza-Software/SprialDatabaseBundle
 */
final class Dump
{
    /**
     * @var string
     */
    private $connection;

    /**
     * @var int
     */
    private $countReadQuery;

    /**
     * @var int
     */
    private $countWriteQuery;

    /**
     * @var array<Query>
     */
    private $queries;

    /**
     * @var float
     */
    private $totalTimeRunQuery;

    /**
     * Dump constructor.
     */
    public function __construct(string $connection)
    {
        $this->totalTimeRunQuery = 0;
        $this->countWriteQuery   = 0;
        $this->countReadQuery    = 0;
        $this->queries           = [];
        $this->connection        = $connection;
    }

    public function addQuery(Query $query): void
    {
        $this->queries[] = $query;
        $this->totalTimeRunQuery += $query->getElapsed();
    }

    public function incrementReadQuery(): void
    {
        ++$this->countReadQuery;
    }

    public function incrementWriteQuery(): void
    {
        ++$this->countWriteQuery;
    }

    public function getCountReadQuery(): int
    {
        return $this->countReadQuery;
    }

    public function getCountWriteQuery(): int
    {
        return $this->countWriteQuery;
    }

    /**
     * @return Query[]
     */
    public function getQueries(): array
    {
        return $this->queries;
    }

    public function isEmpty(): bool
    {
        return [] === $this->queries;
    }

    public function getTotalCountQuery(): int
    {
        return $this->countReadQuery + $this->countWriteQuery;
    }

    public function getTotalTimeRunQuery(): float
    {
        return $this->totalTimeRunQuery;
    }

    public function getConnection(): string
    {
        return $this->connection;
    }

    public function withConnection(): self
    {
        return new self($this->connection);
    }
}
