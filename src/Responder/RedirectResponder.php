<?php
declare(strict_types = 1);

namespace SixQuests\Responder;

use SixQuests\Domain\Model\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class RedirectResponder
 * @package SixQuests\Responder
 */
class RedirectResponder
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
     * Переадресовать пользователя туда, где его место.
     *
     * @param User|null $user
     * @return Response
     */
    public function __invoke(?User $user): Response
    {
        return new RedirectResponse($this->router->generate($user === null ? 'login_form' : 'index'));
    }
}
