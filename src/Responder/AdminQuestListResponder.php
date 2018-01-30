<?php
declare(strict_types = 1);

namespace SixQuests\Responder;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class AdminQuestListResponder
 * @package SixQuests\Responder
 */
class AdminQuestListResponder extends AbstractResponder
{
    protected static $content = 'admin_quest_list.html.twig';

    /**
     * @param array $quests
     * @return Response
     */
    public function __invoke(array $quests): Response
    {
        $this->setVariable('quests', $quests);

        return $this->render();
    }
}