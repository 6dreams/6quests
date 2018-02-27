<?php
declare(strict_types = 1);

namespace SixQuests\Action;

use SixQuests\Domain\Editor\ListRequest;
use SixQuests\Domain\Editor\ModelRequest;
use SixQuests\Domain\Manager\EditorManager;
use SixQuests\Responder\Editor\EditorEditResponder;
use SixQuests\Responder\Editor\EditorListResponder;
use SixQuests\Responder\RouteRedirectResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class EditorAction
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
     *
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
     * Отобразить модель для редактирования.
     *
     * @param Request             $request
     * @param EditorEditResponder $responder
     *
     * @return Response
     */
    public function editorEdit(Request $request, EditorEditResponder $responder): Response
    {
        return $responder(
            $this->manager->getConfig(),
            $this->manager->getItem(new ModelRequest($request))
        );
    }

    /**
     * Сохранить модель в базе.
     *
     * @param Request                $request
     * @param RouteRedirectResponder $responder
     *
     * @return Response
     */
    public function editorSave(Request $request, RouteRedirectResponder $responder): Response
    {
        $query = new ModelRequest($request);

        $this->manager->updateItem($query);

        return $responder('editor_list', ['model' => $query->getModel()]);
    }
}
