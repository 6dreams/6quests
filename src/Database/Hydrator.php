<?php
declare(strict_types = 1);

namespace SixQuests\Database;

use SixQuests\Database\Exception\NotSupportedModelException;
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
     * @param DatabaseUserTransformer $userTransformer
     */
    public function __construct(
        DatabaseUserTransformer $userTransformer
    ) {
        $this->hydrators[$userTransformer->getModel()] = $userTransformer;
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
}
