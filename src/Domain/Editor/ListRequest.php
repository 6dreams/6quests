<?php
declare(strict_types = 1);

namespace SixQuests\Domain\Editor;

use SixDreams\RichModel\Traits\RichModelTrait;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ListRequest
 *
 * @method string getModel();
 * @method int getOffset();
 *
 * @package SixQuests\Domain\Editor
 */
class ListRequest
{
    use RichModelTrait;

    /**
     * @var string|null
     */
    protected $model;

    /**
     * @var int
     */
    protected $offset;

    /**
     * ListRequest constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->model = $request->get('model');
        $this->offset = $request->get('offset', 0);
    }
}
