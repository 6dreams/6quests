<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Team;

use SixQuests\Domain\Model\DTO\TeamInfo;
use SixQuests\Responder\AbstractJsonResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TeamInfoResponder
 */
class TeamInfoResponder extends AbstractJsonResponder
{
    /**
     * Создать ответ от сервера содержащий команду на точке.
     *
     * @param TeamInfo $teamInfo
     *
     * @return Response
     */
    public function __invoke(TeamInfo $teamInfo): Response
    {
        return $this->setData($teamInfo->getJSON())->render();
    }
}
