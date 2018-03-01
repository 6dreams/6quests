<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor;

use SixDreams\RichModel\Traits\RichModelTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ModelRequest
 *
 * @method string getModel();
 * @method int getId();
 */
class ModelRequest
{
    use RichModelTrait;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var int
     */
    protected $id;

    /**
     * ModelRequest constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->model = $request->get('model', '');
        $this->id = (int) $request->get('id', 0);
    }

    /**
     * Получеть значение поля.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        return $this->request->get($name);
    }
}
