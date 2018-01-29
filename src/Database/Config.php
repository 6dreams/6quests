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
 *
 * @package SixQuests\Database
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
     * Собраться из контейнера.
     *
     * @param ContainerInterface $container
     * @return Config
     */
    public static function fromParameters(ContainerInterface $container): self
    {
        $self = new self();

        if (!$container->hasParameter('host')) {
            return $self;
        }

        $self->host     = $container->getParameter('host');
        $self->database = $container->getParameter('database');
        $self->user     = $container->getParameter('user');
        $self->password = $container->getParameter('password');

        return $self;
    }
}
