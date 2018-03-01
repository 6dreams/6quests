<?php
declare(strict_types = 1);

namespace SixQuests\Responder;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class LoginResponder
 */
class LoginResponder extends AbstractResponder
{
    /**
     * @var string что рендерим.
     */
    protected static $content = 'login.html.twig';

    /**
     * @param bool $withError
     *
     * @return Response
     */
    public function __invoke(bool $withError = false): Response
    {
        return $this->setVariable('error', $withError)->render();
    }
}
