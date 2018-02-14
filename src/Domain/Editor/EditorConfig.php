<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor;

use SixQuests\Domain\Manager\EditorManager;
use Symfony\Component\Routing\RouterInterface;

/**
 * Прокси класс между менеджером и респондером. В основном содержит мелочи для отрисовки страницы.
 *
 * @package SixQuests\Domain\Editor
 */
class EditorConfig
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var array
     */
    private $menu = [];

    /**
     * @var EditorModel[]
     */
    private $models = [];

    /**
     * EditorConfig constructor.
     *
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Добавить пункт меню.
     *
     * @param string $model
     * @param string $name
     * @return EditorConfig
     */
    public function addMenuItem(string $model, string $name): self
    {
        $this->menu[] = [
            'link' => $this->router->generate('editor_list', ['model' => $model]),
            'text' => $name
        ];

        return $this;
    }

    /**
     * Добавить модель.
     *
     * @param EditorModel $model
     * @return EditorConfig
     */
    public function addModel(EditorModel $model): self
    {
        $this->models[$model->getModel()] = $model;

        return $this;
    }

    /**
     * Получить модель по её FCQN.
     *
     * @param string $model
     * @return EditorModel
     */
    public function getModel(string $model): EditorModel
    {
        return $this->models[$model];
    }

    /**
     * Получить короткое название.
     *
     * @param string $fcqn
     * @return string
     */
    public function getShortNameByFCQN(string $fcqn): string
    {
        foreach (EditorManager::MAPPINGS as $short => $map) {
            if ($map[0] === $fcqn) {
                return $short;
            }
        }

        return '';
    }

    /**
     * Получение Menu
     *
     * @return array
     */
    public function getMenu(): array
    {
        return $this->menu;
    }
}