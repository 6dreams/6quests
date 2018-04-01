<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Admin;

use SixQuests\Domain\Model\DTO\TeamAdminInfo;
use SixQuests\Domain\Model\Quest;
use SixQuests\Responder\AbstractResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminQuestHandleResponder
 */
class AdminQuestHandleResponder extends AbstractResponder
{
    protected static $content = 'admin/quest_handle.html.twig';

    /**
     * @param Quest           $quest
     * @param TeamAdminInfo[] $teamAdminInfo
     *
     * @return Response
     */
    public function __invoke(Quest $quest, array $teamAdminInfo): Response
    {
        return $this
            ->setVariable('quest', $quest)
            ->setVariable('list', $teamAdminInfo)
            ->render();
    }
}
