<?php
declare(strict_types = 1);

namespace SixQuests\Responder;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AbstractResponder
 * @package SixQuests\Responder
 */
abstract class AbstractResponder
{
    /**
     * @var string
     */
    protected static $content;

    /**
     * @var array
     */
    protected $context = [];

    /**
     * @var TwigEngine
     */
    protected $twig;

    /**
     * AbstractResponder constructor.
     *
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Отрендерить текущую страницу.
     *
     * @return Response
     */
    protected function render(): Response
    {
        return new Response($this->twig->render(static::$content, $this->context));
    }

    /**
     * Сеттер для Context.
     *
     * @param array $context
     * @return $this
     */
    public function setContext(array $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * Указать параметр.
     *
     * @param string $name
     * @param mixed  $value
     * @return AbstractResponder
     */
    public function setVariable(string $name, $value): self
    {
        $this->context[$name] = $value;

        return $this;
    }
}