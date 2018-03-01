<?php
declare(strict_types = 1);

namespace SixQuests\Command;

use SixQuests\Database\Config;
use SixQuests\Database\Driver;
use SixQuests\Domain\Model\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class InstallCommand
 */
class InstallCommand extends Command
{
    private const PARAMS_YML = './config/packages/parameters.yml';
    private const DB_SQL = './config/database.sql';

    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * @var Driver
     */
    protected $driver;

    /**
     * InstallCommand constructor.
     *
     * @param Driver $driver
     */
    public function __construct(Driver $driver)
    {
        $this->driver = $driver;

        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
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
        $this->io = new SymfonyStyle($input, $output);

        $this->io->writeln('6quests Install Script.');
        if (\file_exists(self::PARAMS_YML)) {
            $this->io->writeln(\sprintf('Config file exists (%s)', self::PARAMS_YML));
            if ($this->askUpdateSchema()) {
                $this->updateSchema();
            }
        } else {
            $this->askDatabaseSettings();
            $this->updateSchema();
        }

        $this->askAdminUser();
    }

    /**
     * Запросить и создать пользователя.
     */
    private function askAdminUser(): void
    {
        $login = $this->ask('Admin login');
        $password = $this->ask('Admin password');

        $this->driver->executeUpsert(
            (new User())
                ->setName($login)
                ->setPassword($password)
                ->setRole(User::ROLE_ADMIN)
        );
    }

    /**
     * Обновить схему базы.
     */
    private function updateSchema(): void
    {
        $this->io->writeln('Updating database schema.');
        $queries = \explode('----', \str_replace('&', $this->driver->getPrefix(), \file_get_contents(self::DB_SQL)));
        foreach ($queries as $query) {
            $this->driver->executeRawQuery($query);
        }
        $this->io->writeln('Schema updated.');
    }

    /**
     * Спросить у пользователя, обновить схему?
     *
     * @return bool
     */
    private function askUpdateSchema(): bool
    {
        return \strtolower($this->io->ask('Update database schema?', 'y')) === 'y';
    }

    /**
     * Спросить у пользователя данные для базы данных.
     */
    private function askDatabaseSettings(): void
    {
        $confTitles = [
            'host' => ['title' => 'Database host', 'default' => 'localhost'],
            'user' => 'Database user',
            'password' => 'Database password',
            'database' => 'Database name'
        ];
        $prefix = $this->ask('Database prefix');

        $conf = [];

        foreach ($confTitles as $param => $attrs) {
            $conf[$param] = $this->ask(\is_array($attrs) ? $attrs['title'] : $attrs, \is_array($attrs) ? $attrs['default'] : '');
        }

        $config = Config::fromArray($conf);

        if (!@file_put_contents(self::PARAMS_YML, $config->toYml($prefix))) {
            $this->io->writeln(\sprintf('Failed to write config to "%s", do it manually.', self::PARAMS_YML));
            $this->io->write($config->toYml($prefix), true);
            $this->io->ask('Press enter when done');
        }
        $this->driver->setConfig($config, $prefix);
    }

    /**
     * Спросить у пользователя вопрос.
     *
     * @param string $question
     * @param string $default
     *
     * @return null|string
     */
    private function ask(string $question, string $default = ''): ?string
    {
        return $this->io->ask($question, $default);
    }
}
