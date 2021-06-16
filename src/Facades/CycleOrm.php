<?php

namespace Prokl\WpCycleOrmBundle\Facades;

use Cycle\ORM\Heap\Node;
use Cycle\ORM\RepositoryInterface;
use Cycle\ORM\Select\SourceInterface;
use Prokl\FacadeBundle\Services\AbstractFacade;

/**
 * Class Application
 * @package Prokl\WpCycleOrmBundle\Facades
 *
 * @method static string resolveRole($entity)
 * @method static get(string $role, array $scope, bool $load = true)
 * @method static make(string $role, array $data = [], int $node = Node::NEW)
 * @method static RepositoryInterface getRepository($entity)
 * @method static SourceInterface getSource(string $role)
 */
class CycleOrm extends AbstractFacade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor() : string
    {
        return 'cycle_orm.orm';
    }
}
