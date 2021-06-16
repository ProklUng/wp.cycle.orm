<?php

namespace Prokl\WpCycleOrmBundle\Contracts;

/**
 * Interface EntityManagerInterface
 * @package Prokl\WpCycleOrmBundle\Contracts
 *
 * @since 16.06.2021
 */
interface EntityManagerInterface
{
    /**
     * Find entity by PK.
     *
     * @param string         $entity
     * @param string|integer $id
     *
     * @return object|null
     */
    public function findByPK(string $entity, $id);

    /**
     * Find entity using given scope (where).
     *
     * @param string $entity
     * @param array  $scope
     *
     * @return null|object
     */
    public function findOne(string $entity, array $scope = []);

    /**
     * Find multiple entities using given scope and sort options.
     *
     * @param string $entity
     * @param array  $scope
     *
     * @return mixed
     */
    public function findAll(string $entity, array $scope = []);

    /**
     * @param object  $entity
     * @param boolean $cascade
     * @param boolean $run
     *
     * @return void
     */
    public function persist(object $entity, bool $cascade = true, bool $run = true): void;

    /**
     * @param object  $entity
     * @param boolean $cascade
     * @param boolean $run
     *
     * @return void
     */
    public function delete(object $entity, bool $cascade = true, bool $run = true): void;
}