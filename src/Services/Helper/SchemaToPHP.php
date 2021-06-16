<?php

namespace Prokl\WpCycleOrmBundle\Services\Helper;

use Cycle\ORM\Relation;
use Cycle\ORM\Schema;
use Cycle\ORM\SchemaInterface;

/**
 * Class SchemaToPHP
 * @package Prokl\WpCycleOrmBundle\Services\Helper
 *
 * @since 16.06.2021
 */
class SchemaToPHP
{
    /**
     * @var SchemaInterface $schema
     */
    private $schema;

    private const RELATION = [
        Relation::HAS_ONE => 'Relation::HAS_ONE',
        Relation::HAS_MANY => 'Relation::HAS_MANY',
        Relation::BELONGS_TO => 'Relation::BELONGS_TO',
        Relation::REFERS_TO => 'Relation::REFERS_TO',
        Relation::MANY_TO_MANY => 'Relation::MANY_TO_MANY',
        Relation::BELONGS_TO_MORPHED => 'Relation::BELONGS_TO_MORPHED',
        Relation::MORPHED_HAS_ONE => 'Relation::MORPHED_HAS_ONE',
        Relation::MORPHED_HAS_MANY => 'Relation::MORPHED_HAS_MANY',
    ];

    private const RELATION_OPTION = [
        Relation::CASCADE => 'Relation::CASCADE',
        Relation::NULLABLE => 'Relation::NULLABLE',
        Relation::OUTER_KEY => 'Relation::OUTER_KEY',
        Relation::INNER_KEY => 'Relation::INNER_KEY',
        Relation::WHERE => 'Relation::WHERE',
        Relation::THROUGH_INNER_KEY => 'Relation::THROUGH_INNER_KEY',
        Relation::THROUGH_OUTER_KEY => 'Relation::THROUGH_OUTER_KEY',
        Relation::THROUGH_ENTITY => 'Relation::THROUGH_ENTITY',
        Relation::THROUGH_WHERE => 'Relation::THROUGH_WHERE',
    ];

    private const PREFETCH_MODE = [
        Relation::LOAD_PROMISE => 'Relation::LOAD_PROMISE',
        Relation::LOAD_EAGER => 'Relation::LOAD_EAGER',
    ];

    private const GENERAL_OPTION = [
        Relation::TYPE => 'Relation::TYPE',
        Relation::TARGET => 'Relation::TARGET',
        Relation::SCHEMA => 'Relation::SCHEMA',
        Relation::LOAD => 'Relation::LOAD',
    ];

    private const USE_LIST = [
        Schema::class,
        Relation::class,
    ];

    /**
     * SchemaToPHP constructor.
     *
     * @param SchemaInterface $schema
     */
    public function __construct(SchemaInterface $schema)
    {
        $this->schema = $schema;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }

    /**
     * @return string
     */
    public function render(): string
    {
        $items = new ArrayItem(null);
        foreach ($this->schema->getRoles() as $role) {
            $items->value[] = $this->renderRole($role);
        }

        $result = "<?php\n\n";
        foreach (self::USE_LIST as $use) {
            $result .= "use {$use};\n";
        }
        $result .= "\nreturn {$items};\n";

        return $result;
    }

    /**
     * @param string $role
     *
     * @return ArrayItem|null
     */
    private function renderRole(string $role): ?ArrayItem
    {
        $aliasOf = $this->schema->resolveAlias($role);
        if ($aliasOf !== null && $aliasOf !== $role) {
            // This role is an alias
            return null;
        }
        if ($this->schema->defines($role) === false) {
            // Role has not a definition within the schema
            return null;
        }
        $declaration = new ArrayItem($role, [
            $this->renderDatabase($role),
            $this->renderTable($role),
            $this->renderEntity($role),
            $this->renderMapper($role),
            $this->renderRepository($role),
            $this->renderScope($role),
            $this->renderPK($role),
            $this->renderFields($role),
            $this->renderTypecast($role),
            $this->renderRelations($role),
        ], true);

        return $declaration;
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderDatabase(string $role): ArrayItem
    {
        return new ArrayItem('Schema::DATABASE', $this->schema->define($role, Schema::DATABASE));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderTable(string $role): ArrayItem
    {
        return new ArrayItem('Schema::TABLE', $this->schema->define($role, Schema::TABLE));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderEntity(string $role): ArrayItem
    {
        return new ArrayItem('Schema::ENTITY', $this->schema->define($role, Schema::ENTITY));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderMapper(string $role): ArrayItem
    {
        return new ArrayItem('Schema::MAPPER', $this->schema->define($role, Schema::MAPPER));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderRepository(string $role): ArrayItem
    {
        return new ArrayItem('Schema::REPOSITORY', $this->schema->define($role, Schema::REPOSITORY));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderScope(string $role): ArrayItem
    {
        return new ArrayItem('Schema::CONSTRAIN', $this->schema->define($role, Schema::CONSTRAIN));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderPK(string $role): ArrayItem
    {
        return new ArrayItem('Schema::PRIMARY_KEY', $this->schema->define($role, Schema::PRIMARY_KEY));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderFields(string $role): ArrayItem
    {
        return new ArrayItem('Schema::COLUMNS', $this->schema->define($role, Schema::COLUMNS));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderTypecast(string $role): ArrayItem
    {
        return new ArrayItem('Schema::TYPECAST', $this->schema->define($role, Schema::TYPECAST));
    }

    /**
     * @param string $role
     *
     * @return ArrayItem
     */
    private function renderRelations(string $role): ArrayItem
    {
        $relations = $this->schema->define($role, Schema::RELATIONS);
        $results = [];
        foreach ($relations as $field => $relation) {
            $relationResult = [];
            // replace numeric keys and values to constants
            foreach ($relation as $option => $value) {
                $item = new ArrayItem(self::GENERAL_OPTION[$option] ?? $option, $value);
                if ($option === Relation::LOAD && isset(self::RELATION[$value])) {
                    $item->value = self::PREFETCH_MODE[$value];
                    $item->wrapValue = false;
                } elseif ($option === Relation::TYPE && isset(self::RELATION[$value])) {
                    $item->value = self::RELATION[$value];
                    $item->wrapValue = false;
                } elseif ($option === Relation::SCHEMA) {
                    $resultList = [];
                    foreach ($value as $listKey => $listValue) {
                        $resultList[] = new ArrayItem(
                            array_key_exists($listKey,
                                self::RELATION_OPTION) ? self::RELATION_OPTION[$listKey] : $listKey,
                            $listValue
                        );
                    }
                    $item->value = $resultList;
                }
                $relationResult[] = $item;
            }
            $results[] = new ArrayItem($field, $relationResult, true);
        }

        return new ArrayItem('Schema::RELATIONS', $results);
    }
}