<?php

namespace app\system\form;

use app\system\Model;

class SelectField extends BaseField
{
    public array $options;

    public function __construct(Model $model, string $attr, array $options)
    {

        $this->options = $options;
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

    public function renderInput(): string
    {
        return sprintf('<select name="%s" class="form-control">%s</select>', $this->attr, $this->addOptions($this->model->{$this->attr}));
    }

    public function addOptions($selected): string
    {

        $string = '';

        foreach($this->options as $option) {

            $option['selected'] = $option['value'] == $selected ? 'selected' : '';

            $string .= '<option value="'.$option['value'].'" '.$option['selected'].'>'.$option['name'].'</option>';

        };

        return $string;

    }
}
