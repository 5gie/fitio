<?php

namespace app\system\form;
use app\system\Model;

class TextareaField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';

    public string $type;

    public function __construct(Model $model, string $attr)
    {

        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attr);

    }

    public function __toString()
    {

        return sprintf('
            <div class="mb-3">
                <label class="form-label">%s</label>
                %s
                <div class="invalid-feedback">%s</div>
            </div>
        ', $this->model->getLabel($this->attr), $this->renderInput(), $this->model->getFirstError($this->attr));

    }

    public function renderInput(): string
    {
        return sprintf('<textarea name="%s" class="form-control %s">%s</textarea>', $this->attr, $this->model->hasError($this->attr) ? 'is-invalid' : '', $this->model->{$this->attr});
    }

}
