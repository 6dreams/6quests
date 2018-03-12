<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Manager;

use SixQuests\Database\Driver;
use SixQuests\Domain\Editor\DTO\Item;
use SixQuests\Domain\Editor\DTO\ListItems;
use SixQuests\Domain\Editor\DTO\RelationField;
use SixQuests\Domain\Editor\EditorConfig;
use SixQuests\Domain\Editor\EditorField;
use SixQuests\Domain\Editor\EditorModel;
use SixQuests\Domain\Editor\ListRequest;
use SixQuests\Domain\Editor\ModelRequest;
use SixQuests\Domain\Model\Point;
use SixQuests\Domain\Model\Quest;
use SixQuests\Domain\Model\Team;
use SixQuests\Domain\Model\User;
use SixQuests\Domain\Utility\Utils;

/**
 * Class EditorManager
 */
class EditorManager
{
    public const MAPPINGS = [
        'quest' => [Quest::class, 'Квесты'],
        'user'  => [User::class, 'Пользователи'],
        'point' => [Point::class, 'Точки'],
        'team'  => [Team::class, 'Команды']
    ];

    /**
     * @var EditorConfig
     */
    private $config;

    /**
     * @var Driver
     */
    private $driver;

    /**
     * EditorManager constructor.
     *
     * @param EditorConfig $config
     * @param Driver       $driver
     */
    public function __construct(EditorConfig $config, Driver $driver)
    {
        $this->config = $config;
        $this->driver = $driver;
    }

    /**
     * Получить список для отображения.
     *
     * @param ListRequest $request
     *
     * @return ListItems
     */
    public function getListItems(ListRequest $request): ListItems
    {
        $model = $this->getModel($request->getModel() ?? '');

        return new ListItems($model, $this->driver->executeFind(
            $model,
            \sprintf('SELECT * FROM %s%s LIMIT :offset, 20', $this->driver->getPrefix(), Utils::constant($model, 'TABLE')),
            ['offset' => $request->getOffset()]
        ));
    }

    /**
     * Получить информацию по модели для редактирования.
     *
     * @param ModelRequest $request
     *
     * @return Item
     */
    public function getItem(ModelRequest $request): Item
    {
        $model = $this->getModel($request->getModel());

        $item = $this->driver->executeFind(
            $model,
            \sprintf('SELECT * FROM %s%s WHERE id = :id', $this->driver->getPrefix(), Utils::constant($model, 'TABLE')),
            [ 'id' => $request->getId() ]
        )[0] ?? null;

        if (!$item) {
            $item = new $model();
        }

        return new Item($model, $item);
    }

    /**
     * Сохранить изменения.
     *
     * @param ModelRequest $request
     */
    public function updateItem(ModelRequest $request): void
    {
        $model = $this->getModel($request->getModel());

        if ($request->getId() <= 0) {
            $object = new $model();
        } else {
            $object = $this->driver->executeFind(
                $model,
                \sprintf('SELECT * FROM %s%s WHERE id = :id', $this->driver->getPrefix(), Utils::constant($model, 'TABLE')),
                [ 'id' => $request->getId() ]
            )[0] ?? new $model();
        }

        foreach ($this->getConfig()->getModel($model)->getFields() as $field) {
            if ($field->getType() === EditorField::TYPE_INDEX || !$field->isShowInEdit()) {
                continue;
            }

            $object->{$field->getSetterName()}($request->get($field->getPropertyName()));
        }

        $this->driver->executeUpsert($object);
    }

    /**
     * Получить конфигурацию админки.
     *
     * @return EditorConfig
     */
    public function getConfig(): EditorConfig
    {
        foreach (self::MAPPINGS as $name => $map) {
            $this
                ->config
                ->addMenuItem($name, $map[1]);

            $this->config->addModel($this->getModelDefinition($map[0]));
        }



        return $this->config;
    }

    /**
     * Возвращает FCQN модели.
     *
     * @param string $plan
     *
     * @return string
     */
    private function getModel(string $plan): string
    {
        if (!\array_key_exists($plan, self::MAPPINGS)) {
            $plan = \array_keys(self::MAPPINGS)[0];
        }

        return self::MAPPINGS[$plan][0];
    }

    /**
     * @param string $name
     *
     * @return EditorModel
     */
    private function getModelDefinition(string $name): EditorModel
    {
        $model = new EditorModel($name);

        $model->addField(new EditorField('id', EditorField::TYPE_INDEX, 'ID'));
        switch ($name) {
            case Point::class:
                $model
                    ->addField(new EditorField('name', EditorField::TYPE_INPUT, 'Название'))
                    ->addField(new EditorField('timeLimit', EditorField::TYPE_INPUT, 'Время на загадку'))
                    ->addField(new EditorField('hints', EditorField::TYPE_INPUT, 'Подсказок'))
                    ->addField(new EditorField('hintCost', EditorField::TYPE_INPUT, 'Цена одной подсказки'))
                    ->addField(new EditorField('skipCost', EditorField::TYPE_INPUT, 'Цена пропуска точки'))
                    ->addField(
                        (new EditorField('user', EditorField::TYPE_DB_SELECT))
                            ->setDisplay(EditorField::DISPLAY_LIST)
                            ->setCustomTemplate('editor/editor_list_value_link_user.html.twig')
                    )
                    ->addField(
                        (new EditorField('userId', EditorField::TYPE_DB_SELECT))
                            ->setDisplay(EditorField::DISPLAY_EDIT)
                            ->setRelation(new RelationField(User::class, 'getName'))
                    )
                    ->addField(
                        (new EditorField('quest', EditorField::TYPE_DB_SELECT))
                            ->setDisplay(EditorField::DISPLAY_LIST)
                            ->setCustomTemplate('editor/editor_list_value_link_quest.html.twig')
                    )
                    ->addField(
                        (new EditorField('questId', EditorField::TYPE_DB_SELECT))
                            ->setDisplay(EditorField::DISPLAY_EDIT)
                            ->setRelation(new RelationField(Quest::class, 'getName'))
                    );
                break;
            case Quest::class:
                $model
                    ->addField(new EditorField('name', EditorField::TYPE_INPUT, 'Название'))
                    ->addField(new EditorField('dateString', EditorField::TYPE_INPUT, 'Дата'))
                    ->addField(
                        (new EditorField('state', EditorField::TYPE_SELECT, 'Состояние'))
                            ->setValues([Quest::STATE_ACTIVE => 'Начат', Quest::STATE_FINISHED => 'Завершён', Quest::STATE_UNKNOWN => 'Создан'])
                    );
                break;
            case User::class:
                $model
                    ->addField(new EditorField('name', EditorField::TYPE_INPUT, 'Логин'))
                    ->addField(new EditorField('password', EditorField::TYPE_INPUT, 'Пароль'))
                    ->addField(new EditorField('firstName', EditorField::TYPE_INPUT, 'Имя'))
                    ->addField(new EditorField('lastName', EditorField::TYPE_INPUT, 'Фамилия'))
                    ->addField(
                        (new EditorField('role', EditorField::TYPE_SELECT, 'Роль'))
                            ->setValues([User::ROLE_USER => 'Координатор', User::ROLE_ADMIN => 'Админ'])
                    );
                break;
            case Team::class:
                $model
                    ->addField(new EditorField('name', EditorField::TYPE_INPUT, 'Название'))
                    ->addField(new EditorField('number', EditorField::TYPE_INPUT, 'Номер'))
                    ->addField(new EditorField('color', EditorField::TYPE_INPUT, 'Цвет'))
                    ->addField(
                        (new EditorField('quest', EditorField::TYPE_DB_SELECT, 'Квест'))
                            ->setDisplay(EditorField::DISPLAY_LIST)
                            ->setCustomTemplate('editor/editor_list_value_link_quest.html.twig')
                    )
                    ->addField(
                        (new EditorField('questId', EditorField::TYPE_DB_SELECT, 'Квест'))
                            ->setDisplay(EditorField::DISPLAY_EDIT)
                            ->setRelation(new RelationField(Quest::class, 'getName'))
                    );
                break;
        }

        return $model;
    }
}
