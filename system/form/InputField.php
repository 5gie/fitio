<?php

namespace app\system\form;
use app\system\Model;

class InputField extends BaseField
{
    public const TYPE_TEXT = 'text';
    public const TYPE_PASSWORD = 'password';
    public const TYPE_NUMBER = 'number';
    public const TYPE_FILE = 'file';

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
            </div>
        ', $this->model->getLabel($this->attr), $this->renderInput());

    }

    public function passwordField()
    {

        $this->type = self::TYPE_PASSWORD;
        return $this;

    }

    public function fileField()
    {

        $this->type = self::TYPE_FILE;
        return $this;

    }
    public function numberField()
    {

        $this->type = self::TYPE_NUMBER;
        return $this;

    }

    public function renderInput(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control">', $this->type, $this->attr, $this->model->{$this->attr});
    }

}
