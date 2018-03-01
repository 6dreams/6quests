<?php
declare(strict_types = 1);

namespace SixQuests\Database;

use SixDreams\RichModel\Traits\RichModelTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Config
 *
 * @method string getHost();
 * @method string getDatabase();
 * @method string getUser();
 * @method string getPassword();
 */
class Config
{
    use RichModelTrait;

    /**
     * @var string
     */
    protected $host = '';

    /**
     * @var string
     */
    protected $database = '';

    /**
     * @var string
     */
    protected $user = '';

    /**
     * @var string
     */
    protected $password = '';

    /**
     * Собраться из массива.
     *
     * @param array $data
     *
     * @return Config
     */
    public static function fromArray(array $data): self
    {
        $self = new self();

        $self->user = $data['user'] ?? '';
        $self->host = $data['host'] ?? '';
        $self->database = $data['database'] ?? '';
        $self->password = $data['password'] ?? '';

        return $self;
    }

    /**
     * Собраться из контейнера.
     *
     * @param ContainerInterface $container
     *
     * @return Config
     */
    public static function fromParameters(ContainerInterface $container): self
    {
        $self = new self();

        if (!$container->hasParameter('host')) {
            return $self;
        }

        $self->host     = (string) $container->getParameter('host');
        $self->database = (string) $container->getParameter('database');
        $self->user     = (string) $container->getParameter('user');
        $self->password = (string) $container->getParameter('password');

        return $self;
    }

    /**
     * Превратиться в YML конфиг.
     *
     * @param null|string $prefix
     *
     * @return string
     */
    public function toYml(?string $prefix): string
    {
        return \sprintf(
            "parameters:\n   host: %s\n   user: %s\n   password: %s\n   database: %s\n%s\n",
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $prefix === null || $prefix === '' ? '' : '   prefix: ' . $prefix
        );
    }
}
