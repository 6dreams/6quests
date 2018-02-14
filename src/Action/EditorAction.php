<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Editor\ListRequest;
use SixQuests\Domain\Manager\EditorManager;
use SixQuests\Responder\Editor\EditorListResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EditorAction
 * @package SixQuests\Action
 */
class EditorAction
{
    /**
     * @var EditorManager
     */
    private $manager;

    /**
     * EditorAction constructor.
     *
     * @param EditorManager $manager
     */
    public function __construct(
        EditorManager $manager
    ) {
        $this->manager = $manager;
    }

    /**
     * Отобразить список.
     *
     * @param Request             $request
     * @param EditorListResponder $responder
     * @return Response
     */
    public function editorList(Request $request, EditorListResponder $responder): Response
    {
        return $responder(
            $this->manager->getConfig(),
            $this->manager->getListItems(new ListRequest($request))
        );
    }

    /**
     * @param Request $request
     */
    public function editorEdit(Request $request)
    {
        // stub!
    }
}
