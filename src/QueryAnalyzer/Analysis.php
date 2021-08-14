<?php
/**
 * Spiral Database Bundle
 *
 * @author Vlad Shashkov <root@myaza.info>
 * @copyright Copyright (c) 2021, The Myaza Software
 */

declare(strict_types=1);

namespace Prokl\WpCycleOrmBundle\QueryAnalyzer;

use Prokl\WpCycleOrmBundle\Logger\Query;

final class Analysis
{
    /**
     * @var Query|null
     */
    private $query;

    /**
     * Analysis constructor.
     */
    public function __construct(?Query $query = null)
    {
        $this->query = $query;
    }

    public function hasQuery(): bool
    {
        return null !== $this->query;
    }

    public function getQuery(): Query
    {
        if (!$this->hasQuery()) {
            throw new \LogicException('Not found query');
        }

        /* @phpstan-ignore-next-line */
        return $this->query;
    }
}
