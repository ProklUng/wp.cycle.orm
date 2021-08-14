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

final class QueryAnalyzer
{
    private const QUERY_WRITE_PATTERN = [
        'insert',
        'update',
        'delete',
        'create',
        'alter',
        'drop',
    ];

    private const QUERY_POSTGRES_PATTERN = [
        'tc.constraint_name',
        'pg_indexes',
        'tc.constraint_name',
        'pg_constraint',
        'information_schema',
        'pg_class',
    ];

    /**
     * @param array<string,mixed> $context
     */
    public function analyze(string $text, array $context): Analysis
    {
        if (!$this->isQuery($context)) {
            return new Analysis();
        }

        $query = new Query(
            $text,
            $context['elapsed'],
            $context['rowCount'],
            $this->isWriteQuery($text)
        );

        return new Analysis($query);
    }

    /**
     * @param array<string,mixed> $context
     */
    private function isQuery(array $context): bool
    {
        return array_key_exists('elapsed', $context) && array_key_exists('rowCount', $context);
    }

    private function isWriteQuery(string $query): bool
    {
        $query = strtolower($query);

        if ($this->isPostgresSystemQuery($query)) {
            return false;
        }

        foreach (self::QUERY_WRITE_PATTERN as $pattern) {
            if (0 === strpos($query, $pattern)) {
                return true;
            }
        }

        return false;
    }

    private function isPostgresSystemQuery(string $query): bool
    {
        foreach (self::QUERY_POSTGRES_PATTERN as $pattern) {
            if (strpos($query, $pattern)) {
                return true;
            }
        }

        return false;
    }
}
