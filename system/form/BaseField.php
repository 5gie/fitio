<?php

namespace app\system\form;

use app\system\Model;


abstract class BaseField
{

    public Model $model;
    public string $attr;

    public function __construct(Model $model, string $attr)
    {

        // $this->type = self::TYPE_TEXT;
        $this->model = $model;
        $this->attr = $attr;
    }

    abstract public function renderInput(): string;


    public function __toString()
    {

        return sprintf('
            <div class="mb-3">
                <label class="form-label">%s</label>
                $s
                <div class="invalid-feedback">%s</div>
            </div>
        ', $this->model->getLabel($this->attr), $this->renderInput(), $this->model->getFirstError($this->attr));
    }

}

?>