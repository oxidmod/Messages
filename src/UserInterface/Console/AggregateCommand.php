<?php

declare (strict_types=1);

namespace Oxidmod\Messages\UserInterface\Console;

use League\Tactician\CommandBus;
use Oxidmod\Messages\Command\AggregateLog\AggregateLogCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * CLI command for logs aggregation
 */
class AggregateCommand extends Command
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;

        parent::__construct('messages:aggregate');
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this
            ->setDescription('This command aggregates existing logs.')
            ->addOption('clear-log', null, InputOption::VALUE_OPTIONAL, 'If this option is used then old logs will be deleted.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = $input->hasOption('clear-log') ?
            AggregateLogCommand::clearLog() :
            AggregateLogCommand::preserveLog();

        try {
            $this->commandBus->handle($command);

            $output->writeln('<info>Done!</info>');
        } catch (\Exception $exception) {
            $output->writeln(
                \sprintf('<error>%s</error>', $exception->getMessage())
            );
        }
    }
}
