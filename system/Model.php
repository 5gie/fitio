<?php
namespace app\system;

abstract class Model
{

    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public function data($data)
    {

        foreach($data as $key => $value) {

            if(property_exists($this, $key)) {

                $this->{$key} = $value;

            }

        }

    }

    abstract public function rules(): array;

    public function labels(): array
    {
        return [];
    }

    public function getLabel($attr)
    {
        return $this->labels()[$attr] ?? $attr;
    }

    public array $errors = [];

    public function validate()
    {

        foreach($this->rules() as $attr => $rules){

            $value = $this->{$attr};

            foreach($rules as $rule) {

                $ruleName = $rule;

                if(!is_string($ruleName)) $ruleName = $rule[0];

                if($ruleName === self::RULE_REQUIRED && !$value) $this->addErrorForRule($attr, self::RULE_REQUIRED);

                if($ruleName === self::RULE_EMAIL && !filter_Var($value, FILTER_VALIDATE_EMAIL)) $this->addErrorForRule($attr, self::RULE_EMAIL);

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) $this->addErrorForRule($attr, self::RULE_MIN, [self::RULE_MIN => $rule['min']]);

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) $this->addErrorForRule($attr, self::RULE_MAX, [self::RULE_MIN => $rule['min']]);

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) $this->addErrorForRule($attr, self::RULE_MATCH, [self::RULE_MATCH => $this->getLabel($rule['match'])]);

                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $unique = $rule['attribute'] ?? $attr;
                    $tableName = $className::tableName();

                    $stmt = App::$app->db->prepare("SELECT * FROM $tableName WHERE $unique = :attr ");
                    $stmt->bindValue(":attr", $value);
                    $stmt->execute();
                    $record = $stmt->fetchObject();
                    if($record) $this->addErrorForRule($attr, self::RULE_UNIQUE, ['field' => $this->getLabel($attr)]);
                }
         
            }

        }

        return empty($this->errors);

    }

    private function addErrorForRule(string $attr, string $rule, $replace = [])
    {

        $message = $this->errorMessages()[$rule] ?? '';
        foreach($replace as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attr][] = $message;

    }

    public function addError(string $attr, string $message)
    {
        $this->errors[$attr][] = $message;
    }

    public function errorMessages()
    {

        return  [

            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exists' 

        ];

    }

    public function hasError($attr)
    {
        return $this->errors[$attr] ?? false;
    }

    public function getFirstError($attr)
    {
        return $this->errors[$attr][0] ?? false;
    }

}