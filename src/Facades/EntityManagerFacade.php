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
 * @method static findByPK(string $entity, $id)
 * @method static findOne(string $entity, array $scope = [])
 * @method static findAll(string $entity, array $scope = [])
 * @method static void persist(object $entity, bool $cascade = true, bool $run = true)
 * @method static void delete(object $entity, bool $cascade = true, bool $run = true)
 */
class EntityManagerFacade extends AbstractFacade
{
    /**
     * @inheritDoc
     */
    protected static function getFacadeAccessor() : string
    {
        return 'cycle_orm.entity_manager';
    }
}
