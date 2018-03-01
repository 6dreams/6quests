<?php
declare(strict_types = 1);

namespace SixQuests\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand
 */
class InstallCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('quests:install')
            ->setDescription('Installer.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$style = new SymfonyStyle($input, $output);

        // check hasDbSettings (params)
        // ask db settings
        // save
        // update schema
        // ask about admin user
        // create it
    }
}
