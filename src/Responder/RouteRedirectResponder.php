<?php
declare(strict_types=1);

namespace SixQuests\Responder;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RouteRedirectResponder
 * @package SixQuests\Responder
 */
class RouteRedirectResponder
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * RedirectResponder constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Переадресовать пользователя на определённый маршрут.
     *
     * @param string $route
     * @param array  $params
     * @return RedirectResponse
     */
    public function __invoke(string $route, array $params = []): RedirectResponse
    {
        return new RedirectResponse($this->router->generate($route, $params));
    }
}