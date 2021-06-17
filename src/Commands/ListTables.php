<?php

namespace Prokl\WpCycleOrmBundle\Commands;

use Exception;
use Spiral\Database\Database;
use Spiral\Database\DatabaseManager;
use Spiral\Database\Driver\Driver;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableSeparator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Throwable;

/**
 * Class ListTables
 * @package Prokl\WpCycleOrmBundle\Commands
 */
class ListTables extends Command
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
        $this->setName('cycle_entity:list_db')
            ->setDescription('Get list of available databases, their tables and records count.')
            ->setHelp('Get list of available databases, their tables and records count.')
            ->addArgument('db', InputArgument::OPTIONAL, 'Database name', 'default');
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->output = $output;

        $databases = [$input->getArgument('db')];

        if (empty($databases)) {
            $output->writeln('<fg=red>No databases found.</fg=red>');

            return 1;
        }

        $grid = $this->table([
            'Name (ID):',
            'Database:',
            'Driver:',
            'Prefix:',
            'Status:',
            'Tables:',
            'Count Records:'
        ]);

        foreach ($databases as $database) {
            $database = $this->dbal->database($database);

            /** @var Driver $driver */
            $driver = $database->getDriver();

            $header = [
                $database->getName(),
                $driver->getSource(),
                $driver->getType(),
                $database->getPrefix() ?: self::SKIP
            ];

            try {
                $driver->connect();
            } catch (Exception $exception) {
                $this->renderException($grid, $header, $exception);

                if ($database->getName() !== end($databases)) {
                    $grid->addRow(new TableSeparator());
                }

                continue;
            }

            $header[] = '<info>connected</info>';
            $this->renderTables($grid, $header, $database);
            if ($database->getName() !== end($databases)) {
                $grid->addRow(new TableSeparator());
            }
        }

        $grid->render();

        return 0;
    }

    /**
     * @param Table     $grid
     * @param array     $header
     * @param Throwable $exception
     *
     * @return void
     */
    private function renderException(Table $grid, array $header, Throwable $exception): void
    {
        $grid->addRow(array_merge(
            $header,
            [
                "<fg=red>{$exception->getMessage()}</fg=red>",
                self::SKIP,
                self::SKIP
            ]
        ));
    }

    /**
     * @param Table    $grid
     * @param array    $header
     * @param Database $database
     *
     * @return void
     */
    private function renderTables(Table $grid, array $header, Database $database): void
    {
        foreach ($database->getTables() as $table) {
            $grid->addRow(array_merge(
                $header,
                [$table->getName(), number_format($table->count())]
            ));
            $header = ['', '', '', '', ''];
        }

        $header[1] && $grid->addRow(array_merge($header, ['no tables', 'no records']));
    }

    /**
     * Table helper instance with configured header and pre-defined set of rows.
     *
     * @param array  $headers
     * @param array  $rows
     * @param string $style
     *
     * @return Table
     */
    private function table(
        array $headers,
        array $rows = [],
        string $style = 'default'
    ): Table {
        $table = new Table($this->output);

        return $table->setHeaders($headers)->setRows($rows)->setStyle($style);
    }
}
