<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Point;

use SixQuests\Responder\AbstractResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PointListResponder
 * @package SixQuests\Responder\Point
 */
class PointListResponder extends AbstractResponder
{
    /**
     * @var string что рендерим.
     */
    protected static $content = 'point/list.html.twig';

    /**
     * Отрендерить страницу со списком точек.
     *
     * @param array $points
     * @return Response
     */
    public function __invoke(array $points): Response
    {
        return $this->setVariable('points', $points)->render();
    }
}
