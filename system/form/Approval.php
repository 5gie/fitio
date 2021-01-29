<?php

namespace app\system\form;

use app\system\Model;

class Approval extends BaseField
{
    public const TYPE_CHECKBOX = 'checkbox';

    public string $type;

    public function __construct(Model $model, string $attr)
    {

        $this->type = self::TYPE_CHECKBOX;
        parent::__construct($model, $attr);
    }

    public function __toString()
    {

        return sprintf('
            <div class="mb-3">
                <label class="form-label">%s %s</label>
                
            </div>
        ', $this->renderInput(), $this->model->getLabel($this->attr));
    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s">', $this->type, $this->attr);
    }
}