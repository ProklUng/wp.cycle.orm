<?php

namespace Prokl\WpCycleOrmBundle\Services;

use Spiral\Tokenizer\ClassesInterface;
use Spiral\Tokenizer\Config\TokenizerConfig;
use Spiral\Tokenizer\Tokenizer;

/**
 * Class ClassLocator
 * @package Prokl\WpCycleOrmBundle\Services
 *
 * @since 07.04.2021
 */
class ClassLocator
{
    /**
     * @var string $path Путь, где искать классы.
     */
    private $path;

    /**
     * ClassLocator constructor.
     *
     * @param string $path Путь, где искать классы.
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Экземпляр локатора.
     *
     * @return ClassesInterface
     */
    public function getLocator() : ClassesInterface
    {
        return (new Tokenizer(new TokenizerConfig([
            'directories' => [$this->path],
        ])))->classLocator();
    }
}
