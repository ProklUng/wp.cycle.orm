<?php

namespace Prokl\WpCycleOrmBundle\Entity;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Transaction;
use Prokl\WpCycleOrmBundle\Contracts\EntityManagerInterface;
use Throwable;

/**
 * Class Manager
 * @package Prokl\WpCycleOrmBundle\Entity
 *
 * @since 16.06.2021
 */
class Manager implements EntityManagerInterface
{
    /**
     * @var ORMInterface $orm ORM.
     */
    private $orm;

    /**
     * Manager constructor.
     *
     * @param ORMInterface $orm ORM.
     */
    public function __construct(ORMInterface $orm)
    {
        $this->orm = $orm;
    }

    /**
     * {@inheritDoc}
     */
    public function findByPK(string $entity, $id)
    {
        return $this->orm->getRepository($entity)->findByPK($id);
    }

    /**
     * {@inheritDoc}
     */
    public function findOne(string $entity, array $scope = [])
    {
        return $this->orm->getRepository($entity)->findOne($scope);
    }

    /**
     * {@inheritDoc}
     */
    public function findAll(string $entity, array $scope = [])
    {
        return $this->orm->getRepository($entity)->findAll($scope);
    }

    /**
     * {@inheritDoc}
     * @throws Throwable
     */
    public function persist(object $entity, bool $cascade = true, bool $run = true): void
    {
        $tr = new Transaction($this->orm);
        $tr->persist($entity, $cascade ? Transaction::MODE_CASCADE : Transaction::MODE_ENTITY_ONLY);

        if ($run) {
            $tr->run();
        }
    }

    /**
     * {@inheritDoc}
     * @throws Throwable
     */
    public function delete(object $entity, bool $cascade = true, bool $run = true): void
    {
        $tr = new Transaction($this->orm);
        $tr->delete($entity, $cascade ? Transaction::MODE_CASCADE : Transaction::MODE_ENTITY_ONLY);

        if ($run) {
            $tr->run();
        }
    }
}