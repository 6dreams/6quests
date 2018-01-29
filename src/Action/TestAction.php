<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Database\Driver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class TestAction
{
    public function __invoke(Request $request, Session $session, Driver $sql)
    {
        return new Response($request->getUri() . \get_class($session));
    }
}