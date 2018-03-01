<?php
declare(strict_types = 1);

namespace SixQuests\Responder;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class AbstractJsonResponder
 */
abstract class AbstractJsonResponder
{
    /**
     * @var array
     */
    private $data = [];

    /**
     * Указать параметр.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return AbstractJsonResponder
     */
    public function setVariable(string $name, $value): self
    {
        $this->data[$name] = $value;

        return $this;
    }

    /**
     * Указать все данные для ответа.
     *
     * @param array $value
     *
     * @return AbstractJsonResponder
     */
    public function setData(array $value): self
    {
        $this->data = $value;

        return $this;
    }

    /**
     * Создать ответ JSON.
     *
     * @return JsonResponse
     */
    protected function render(): JsonResponse
    {
        return new JsonResponse($this->data);
    }
}
