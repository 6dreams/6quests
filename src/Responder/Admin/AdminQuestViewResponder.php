<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Admin;

use SixQuests\Domain\Model\Quest;
use SixQuests\Responder\AbstractResponder;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminQuestViewResponder
 */
class AdminQuestViewResponder extends AbstractResponder
{
    protected static $content = 'admin/quest_view.html.twig';

    /**
     * Отобразить страницу.
     *
     * @param Quest $quest
     *
     * @return Response
     */
    public function __invoke(Quest $quest): Response
    {
        return $this
            ->setVariable('quest', $quest)
            ->render();
    }
}
