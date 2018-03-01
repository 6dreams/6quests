<?php
declare(strict_types = 1);

namespace SixQuests\Responder\Editor;

use SixQuests\Domain\Editor\EditorConfig;
use SixQuests\Responder\AbstractResponder;

/**
 * Class AbstractEditorResponder
 */
abstract class AbstractEditorResponder extends AbstractResponder
{
    /**
     * @var EditorConfig
     */
    protected $config;

    /**
     * Подготовить абстрактный responder.
     *
     * @param EditorConfig $config
     *
     * @return AbstractEditorResponder
     */
    protected function prepare(EditorConfig $config): self
    {
        $this->config = $config;

        $this
            ->setVariable('config', $this->config);

        return $this;
    }
}
