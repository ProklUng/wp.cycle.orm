<?php
/**
 * Spiral Database Bundle
 *
 * @author Vlad Shashkov <root@myaza.info>
 * @copyright Copyright (c) 2021, The Myaza Software
 */

declare(strict_types=1);

namespace Prokl\WpCycleOrmBundle\Twig;

use Doctrine\SqlFormatter\HtmlHighlighter;
use Doctrine\SqlFormatter\SqlFormatter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * @internal Fork from https://github.com/Myaza-Software/SprialDatabaseBundle
 */
final class QueryFormatterExtension extends AbstractExtension
{
    /**
     * @var SqlFormatter
     */
    private $sqlFormatter;

    public function __construct()
    {
        $this->sqlFormatter = new SqlFormatter(new HtmlHighlighter([
            HtmlHighlighter::HIGHLIGHT_PRE            => 'class="highlight highlight-sql"',
            HtmlHighlighter::HIGHLIGHT_QUOTE          => 'class="string"',
            HtmlHighlighter::HIGHLIGHT_BACKTICK_QUOTE => 'class="string"',
            HtmlHighlighter::HIGHLIGHT_RESERVED       => 'class="keyword"',
            HtmlHighlighter::HIGHLIGHT_BOUNDARY       => 'class="symbol"',
            HtmlHighlighter::HIGHLIGHT_NUMBER         => 'class="number"',
            HtmlHighlighter::HIGHLIGHT_WORD           => 'class="word"',
            HtmlHighlighter::HIGHLIGHT_ERROR          => 'class="error"',
            HtmlHighlighter::HIGHLIGHT_COMMENT        => 'class="comment"',
            HtmlHighlighter::HIGHLIGHT_VARIABLE       => 'class="variable"',
        ]));
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('spiral_prettify_sql', [$this, 'prettifySql'], ['is_safe' => ['html']]),
            new TwigFilter('spiral_format_sql', [$this, 'formatSql'], ['is_safe' => ['html']]),
        ];
    }

    public function prettifySql(string $sql): string
    {
        return $this->sqlFormatter->highlight($sql);
    }

    public function formatSql(string $sql): string
    {
        return $this->sqlFormatter->format($sql);
    }
}
