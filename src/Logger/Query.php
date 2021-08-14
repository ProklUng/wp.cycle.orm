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
final class Query
{
    /**
     * @var string
     */
    private $sql;

    /**
     * @var float
     */
    private $elapsed;

    /**
     * @var int
     */
    private $rowCount;

    /**
     * @var bool
     */
    private $isWrite;

    /**
     * Query constructor.
     */
    public function __construct(string $sql, float $elapsed, int $rowCount, bool $isWrite)
    {
        $this->sql      = $sql;
        $this->elapsed  = $elapsed;
        $this->rowCount = $rowCount;
        $this->isWrite  = $isWrite;
    }

    public function getSql(): string
    {
        return $this->sql;
    }

    public function getElapsed(): float
    {
        return $this->elapsed;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function isWrite(): bool
    {
        return $this->isWrite;
    }
}
