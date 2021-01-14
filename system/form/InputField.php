<?php

namespace app\system\form;
use app\system\Model;

class InputField extends BaseField
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

    public function passwordField()
    {

        $this->type = self::TYPE_PASSWORD;
        return $this;

    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control %s">', $this->type, $this->attr, $this->model->{$this->attr}, $this->model->hasError($this->attr) ? 'is-invalid' : '');
    }

}
