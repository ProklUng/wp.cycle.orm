<?php

namespace Prokl\WpCycleOrmBundle\Commands;

use Cycle\ORM\ORMInterface;
use Cycle\ORM\Schema;
use Cycle\ORM\SchemaInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class EntitiesList
 * Список ORM сущностей, зарегистрированных в системе.
 * @package Prokl\WpCycleOrmBundle\Commands
 */
final class EntitiesList extends Command
{
    /**
     * @var ORMInterface $orm ORM.
     */
    private $orm;

    /**
     * EntitiesList constructor.
     *
     * @param ORMInterface $orm ORM.
     */
    public function __construct(ORMInterface $orm)
    {
        $this->orm = $orm;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('cycle_entity:list')
            ->setDescription('List of all available entities Cycle and their tables.')
            ->setHelp('List of all available entities Cycle and their tables.');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->perform($this->orm, $output);

        return 0;
    }

    /**
     * @param ORMInterface    $orm    ORM.
     * @param OutputInterface $output Output interface.
     *
     * @return void
     */
    private function perform(ORMInterface $orm, OutputInterface $output): void
    {
        $grid = $this->table(
            $output,
            [
                'Role:',
                'Class:',
                'Table:',
                'Repository:',
                'Fields:',
                'Relations:',
            ]);

        if ($orm->getSchema()->getRoles() === []) {
            $output->writeln('<info>No entity were found</info>');

            return;
        }

        foreach ($orm->getSchema()->getRoles() as $role) {
            $grid->addRow($this->describeEntity($orm->getSchema(), $role));
        }

        $grid->render();
    }

    /**
     * @param SchemaInterface $schema Схема.
     * @param string          $role   Role.
     *
     * @return array
     */
    protected function describeEntity(SchemaInterface $schema, string $role): array
    {
        return [
            $role,
            $schema->define($role, Schema::ENTITY),
            $schema->define($role, Schema::TABLE),
            $schema->define($role, Schema::REPOSITORY),
            implode(', ', array_keys($schema->define($role, Schema::COLUMNS))),
            implode(', ', array_keys($schema->define($role, Schema::RELATIONS))),
        ];
    }

    /**
     * Table helper instance with configured header and pre-defined set of rows.
     *
     * @param OutputInterface $output
     * @param array $headers
     * @param array $rows
     * @param string $style
     *
     * @return Table
     */
    protected function table(
        OutputInterface $output,
        array $headers,
        array $rows = [],
        string $style = 'default'
    ): Table {
        $table = new Table($output);

        return $table->setHeaders($headers)->setRows($rows)->setStyle($style);
    }
}
