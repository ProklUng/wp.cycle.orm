<?php

namespace Prokl\WpCycleOrmBundle\Commands;

use DateTimeInterface;
use Spiral\Database\Database;
use Spiral\Database\DatabaseManager;
use Spiral\Database\Exception\DBALException;
use Spiral\Database\Injection\FragmentInterface;
use Spiral\Database\Schema\AbstractColumn;
use Spiral\Database\Schema\AbstractTable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class Table
 * @package Prokl\WpCycleOrmBundle\Commands
 */
final class Table extends Command
{
    /**
     * No information available placeholder.
     */
    private const SKIP = '<comment>---</comment>';

    /**
     * @var DatabaseManager $dbal
     */
    private $dbal;

    /**
     * @var OutputInterface $output
     */
    private $output;

    /**
     * @var InputInterface $input
     */
    private $input;

    /**
     * Table constructor.
     *
     * @param DatabaseManager $dbal
     */
    public function __construct(DatabaseManager $dbal)
    {
        $this->dbal = $dbal;
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName('cycle_entity:table')
            ->setDescription('Describe table schema of specific database.')
            ->setHelp('Describe table schema of specific database.')
            ->addArgument('table', InputArgument::REQUIRED, 'Table name')
            ->addOption('database', 'db', InputArgument::OPTIONAL, 'Source database', 'default');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;
        $this->input = $input;

        $database = $this->dbal->database($input->getOption('database'));

        $schema = $database->table($input->getArgument('table'))->getSchema();

        if (!$schema->exists()) {
            throw new DBALException(
                "Table {$database->getName()}.{$input->getArgument('table')} does not exists."
            );
        }

        $output->writeln(
            sprintf(
                "\n<fg=cyan>Columns of </fg=cyan><comment>%s.%s</comment>:\n",
                $database->getName(),
                $input->getArgument('table')
            )
        );

        $this->describeColumns($schema);

        if (!empty($indexes = $schema->getIndexes())) {
            $this->describeIndexes($database, $indexes);
        }

        if (!empty($foreignKeys = $schema->getForeignKeys())) {
            $this->describeForeignKeys($database, $foreignKeys);
        }

        $output->writeln("\n");

        return 0;
    }

    /**
     * @param AbstractTable $schema
     *
     * @return void
     */
    private function describeColumns(AbstractTable $schema): void
    {
        $columnsTable = $this->table([
            'Column:',
            'Database Type:',
            'Abstract Type:',
            'PHP Type:',
            'Default Value:',
        ]);

        foreach ($schema->getColumns() as $column) {
            $name = $column->getName();

            if (in_array($column->getName(), $schema->getPrimaryKeys(), true)) {
                $name = "<fg=magenta>{$name}</fg=magenta>";
            }

            $columnsTable->addRow([
                $name,
                $this->describeType($column),
                $this->describeAbstractType($column),
                $column->getType(),
                $this->describeDefaultValue($column) ?: self::SKIP,
            ]);
        }

        $columnsTable->render();
    }

    /**
     * @param Database $database
     * @param array    $indexes
     *
     * @return void
     */
    private function describeIndexes(Database $database, array $indexes): void
    {
        $this->output->writeln(
            sprintf(
                "\n<fg=cyan>Indexes of </fg=cyan><comment>%s.%s</comment>:\n",
                $database->getName(),
                $this->input->getArgument('table')
            )
        );

        $indexesTable = $this->table(['Name:', 'Type:', 'Columns:']);
        foreach ($indexes as $index) {
            $indexesTable->addRow([
                $index->getName(),
                $index->isUnique() ? 'UNIQUE INDEX' : 'INDEX',
                implode(', ', $index->getColumns()),
            ]);
        }

        $indexesTable->render();
    }

    /**
     * @param Database $database
     * @param array    $foreignKeys
     *
     * @return void
     */
    private function describeForeignKeys(Database $database, array $foreignKeys): void
    {
        $this->output->writeln(
            sprintf(
                "\n<fg=cyan>Foreign Keys of </fg=cyan><comment>%s.%s</comment>:\n",
                $database->getName(),
                $this->input->getArgument('table')
            )
        );
        $foreignTable = $this->table([
            'Name:',
            'Column:',
            'Foreign Table:',
            'Foreign Column:',
            'On Delete:',
            'On Update:',
        ]);

        foreach ($foreignKeys as $reference) {
            $foreignTable->addRow([
                $reference->getName(),
                $reference->getColumn(),
                $reference->getForeignTable(),
                $reference->getForeignKey(),
                $reference->getDeleteRule(),
                $reference->getUpdateRule(),
            ]);
        }

        $foreignTable->render();
    }

    /**
     * @param AbstractColumn $column
     *
     * @return string|null
     */
    private function describeDefaultValue(AbstractColumn $column): ?string
    {
        $defaultValue = $column->getDefaultValue();

        if ($defaultValue instanceof FragmentInterface) {
            $defaultValue = "<info>{$defaultValue}</info>";
        }

        if ($defaultValue instanceof DateTimeInterface) {
            $defaultValue = $defaultValue->format('c');
        }

        return $defaultValue;
    }

    /**
     * @param AbstractColumn $column
     *
     * @return string
     */
    private function describeType(AbstractColumn $column): string
    {
        $type = $column->getType();

        $abstractType = $column->getAbstractType();

        if ($column->getSize()) {
            $type .= " ({$column->getSize()})";
        }

        if ($abstractType === 'decimal') {
            $type .= " ({$column->getPrecision()}, {$column->getScale()})";
        }

        return $type;
    }

    /**
     * @param AbstractColumn $column
     *
     * @return string
     */
    private function describeAbstractType(AbstractColumn $column): string
    {
        $abstractType = $column->getAbstractType();

        if (in_array($abstractType, ['primary', 'bigPrimary'])) {
            $abstractType = "<fg=magenta>{$abstractType}</fg=magenta>";
        }

        return $abstractType;
    }

    /**
     * Table helper instance with configured header and pre-defined set of rows.
     *
     * @param array  $headers
     * @param array  $rows
     * @param string $style
     *
     * @return \Symfony\Component\Console\Helper\Table
     */
    protected function table(
        array $headers,
        array $rows = [],
        string $style = 'default'
    ): \Symfony\Component\Console\Helper\Table {
        $table = new \Symfony\Component\Console\Helper\Table($this->output);

        return $table->setHeaders($headers)->setRows($rows)->setStyle($style);
    }
}
