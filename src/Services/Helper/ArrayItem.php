<?php

namespace Prokl\WpCycleOrmBundle\Services\Helper;

/**
 * Class ArrayItem
 * @package Prokl\WpCycleOrmBundle\Services\Helper
 *
 * @since 16.06.2021
 */
class ArrayItem
{
    /**
     * @var string|null
     */
    public $key;

    /**
     * @var mixed
     */
    public $value;

    /**
     * @var bool
     */
    public $wrapValue = true;

    /**
     * @var bool
     */
    public $wrapKey;

    /**
     * ArrayItem constructor.
     *
     * @param string|null $key
     * @param mixed|null  $value
     * @param boolean     $wrapKey
     */
    public function __construct(?string $key, $value = null, bool $wrapKey = false)
    {
        $this->key = $key;
        $this->value = $value;
        $this->wrapKey = $wrapKey;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = '';
        if ($this->key !== null) {
            $result = $this->wrapKey ? "'{$this->key}' => " : "{$this->key} => ";
        }

        return $result.$this->renderValue($this->value);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    private function renderValue($value)
    {
        if ($value === null) {
            return 'null';
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }
        if (is_array($value)) {
            if (count($value) === 0) {
                return '[]';
            }
            $result = '[';
            foreach ($value as $key => $item) {
                $result .= "\n";
                if (!$item instanceof ArrayItem) {
                    $result .= is_int($key) ? "{$key} => " : "'{$key}' => ";
                }
                $result .= $this->renderValue($item).',';
            }

            return str_replace("\n", "\n    ", $result)."\n]";
        }
        if (!$this->wrapValue || is_int($value) || $value instanceof ArrayItem) {
            return (string)$value;
        }

        return "'".addslashes((string)$value)."'";
    }
}