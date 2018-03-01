<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Point;

use SixQuests\Domain\Model\DTO\TeamInfo;
use SixQuests\Domain\Model\Point;
use SixQuests\Responder\AbstractResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PointViewResponder
 */
class PointViewResponder extends AbstractResponder
{
    /**
     * @var string что рендерим.
     */
    protected static $content = 'point/view.html.twig';

    /**
     * Создать страницу для отображения команд на точке.
     *
     * @param Point      $point
     * @param TeamInfo[] $teams
     *
     * @return Response
     */
    public function __invoke(Point $point, array $teams): Response
    {
        return $this
            ->setVariable('point', $point)
            ->setVariable('infos', $teams)
            ->render();
    }
}
