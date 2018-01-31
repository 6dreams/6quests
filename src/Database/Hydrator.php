<?php
declare(strict_types = 1);

namespace SixQuests\Database;

use SixQuests\Database\DTO\Query;
use SixQuests\Database\Exception\NotSupportedModelException;
use SixQuests\Domain\Transformer\DatabasePointTransformer;
use SixQuests\Domain\Transformer\DatabaseQuestTransformer;
use SixQuests\Domain\Transformer\DatabaseTeamPointTransformer;
use SixQuests\Domain\Transformer\DatabaseTeamTransformer;
use SixQuests\Domain\Transformer\DatabaseUserTransformer;

/**
 * Class Hydrator
 * @package SixQuests\Database
 */
class Hydrator
{
    /**
     * @var DatabaseTransformerInterface[]
     */
    private $hydrators = [];

    /**
     * Hydrator constructor.
     *
     * @param DatabaseUserTransformer      $userTransformer
     * @param DatabaseQuestTransformer     $questTransformer
     * @param DatabasePointTransformer     $pointTransformer
     * @param DatabaseTeamPointTransformer $teamPointTransformer
     * @param DatabaseTeamTransformer      $teamTransformer
     */
    public function __construct(
        DatabaseUserTransformer $userTransformer,
        DatabaseQuestTransformer $questTransformer,
        DatabasePointTransformer $pointTransformer,
        DatabaseTeamPointTransformer $teamPointTransformer,
        DatabaseTeamTransformer $teamTransformer
    ) {
        $this->hydrators[$userTransformer->getModel()] = $userTransformer;
        $this->hydrators[$questTransformer->getModel()] = $questTransformer;
        $this->hydrators[$pointTransformer->getModel()] = $pointTransformer;
        $this->hydrators[$teamPointTransformer->getModel()] = $teamPointTransformer;
        $this->hydrators[$teamTransformer->getModel()] = $teamTransformer;
    }

    /**
     * Превратить ответ базы данных в объект.
     *
     * @param string $model
     * @param array  $data
     * @return mixed
     * @throws NotSupportedModelException
     */
    public function hydrate(string $model, array $data)
    {
        if (!\array_key_exists($model, $this->hydrators)) {
            throw new NotSupportedModelException($model);
        }

        return $this->hydrators[$model]->transform($data);
    }

    /**
     * Превратить объект в запрос в базу, для создания или сохранения его там.
     *
     * @param mixed $model
     * @return Query
     * @throws NotSupportedModelException
     */
    public function dehydrate($model): Query
    {
        $class = \get_class($model);
        if (!\array_key_exists($class, $this->hydrators)) {
            throw new NotSupportedModelException($class);
        }

        return $this->hydrators[$class]->detransform($model);
    }
}
