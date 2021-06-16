<?php

namespace Prokl\WpCycleOrmBundle\Schemas;

use Cycle\ORM\Schema;
use Prokl\WpCycleOrmBundle\Contracts\AbstractCycleSchema;
use Prokl\WpCycleOrmBundle\Entities\User;

/**
 * Class UserSchema
 * @package Prokl\WpCycleOrmBundle\Schemas
 *
 * @since 07.04.2021
 */
class UserSchema extends AbstractCycleSchema
{
    protected $table = 'user';

    protected $entityClass = User::class;

    /**
     * @inheritDoc
     */
    public function schema() : array
    {
        return [
            $this->entityClass => [
                Schema::MAPPER      => $this->mapperClass,
                Schema::ENTITY      => $this->entityClass,
                Schema::DATABASE    => $this->database,
                Schema::TABLE       => $this->table,
                Schema::PRIMARY_KEY => 'ID',
                Schema::COLUMNS     => [
                    'ID'   => 'ID',  // property => column
                    'username' => 'user_login',
                    'password' => 'user_pass',
                    'nicename' => 'user_nicename',
                    'email' => 'user_email',
                    'url' => 'user_url',
                    'registeredDate' => 'user_registered',
                    'activationKey' => 'user_activation_key',
                    'status' => 'user_status',
                    'displayName' => 'display_name',
                ],
                Schema::TYPECAST    => [
                    'ID' => 'int',

                ],
                Schema::RELATIONS   => [

                ]
            ]
        ];
    }
}
