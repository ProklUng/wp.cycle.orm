<?php

namespace Prokl\WpCycleOrmBundle\Repository;

use Cycle\ORM\Select;
use Cycle\ORM\Select\Repository as BaseRepository;
use Cycle\ORM\Transaction;
use Cycle\ORM\TransactionInterface;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Class Repository
 * @package Prokl\WpCycleOrmBundle\Repository
 *
 * @since 16.06.2021
 */
class Repository extends BaseRepository
{
    /**
     * @var TransactionInterface $transaction
     */
    private $transaction;

    /**
     * @param Select               $select
     * @param TransactionInterface $transaction
     */
    public function __construct(Select $select, TransactionInterface $transaction)
    {
        $this->transaction = $transaction;

        parent::__construct($select);
    }

    /**
     * Find multiple entities using given scope and sort options.
     *
     * @param array $scope
     * @param array $orderBy
     *
     * @return Collection
     */
    public function findAll(array $scope = [], array $orderBy = []): Collection
    {
        return $this->newCollection(
            parent::findAll($scope, $orderBy)
        );
    }

    /**
     * Persist the entity.
     *
     * @param object  $entity
     * @param boolean $cascade
     * @param boolean $run     Commit transaction
     *
     * @throws Throwable
     */
    public function persist($entity, bool $cascade = true, bool $run = true): void
    {
        $this->transaction->persist(
            $entity,
            $cascade ? Transaction::MODE_CASCADE : Transaction::MODE_ENTITY_ONLY
        );

        if ($run) {
            $this->transaction->run(); // transaction is clean after run
        }
    }

    /**
     * Delete entity from the database.
     *
     * @param mixed   $entity
     * @param boolean $cascade
     * @param boolean $run
     *
     * @return void
     * @throws Throwable
     */
    public function delete($entity, bool $cascade = true, bool $run = true)
    {
        $this->transaction->delete(
            $entity,
            $cascade ? Transaction::MODE_CASCADE : Transaction::MODE_ENTITY_ONLY
        );

        if ($run) {
            $this->transaction->run(); // transaction is clean after run
        }
    }

    /**
     * Create a new collection of entities
     *
     * @param iterable $items
     * @return Collection
     */
    protected function newCollection(iterable $items): Collection
    {
        return new Collection($items);
    }

}