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
    public const RULE_APPROVAL = 'approval';

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

                if($ruleName === self::RULE_REQUIRED && !$value) $this->addErrorForRule(self::RULE_REQUIRED);

                if($ruleName === self::RULE_EMAIL && !filter_Var($value, FILTER_VALIDATE_EMAIL)) $this->addErrorForRule(self::RULE_EMAIL);

                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) $this->addErrorForRule(self::RULE_MIN, [self::RULE_MIN => $rule['min']]);

                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) $this->addErrorForRule(self::RULE_MAX, [self::RULE_MIN => $rule['min']]);

                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) $this->addErrorForRule(self::RULE_MATCH, [self::RULE_MATCH => $this->getLabel($rule['match'])]);

                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $unique = $rule['attribute'] ?? $attr;
                    $tableName = $className::tableName();

                    $stmt = App::$app->db->prepare("SELECT * FROM $tableName WHERE $unique = :attr ");
                    $stmt->bindValue(":attr", $value);
                    $stmt->execute();
                    $record = $stmt->fetchObject();
                    if($record) $this->addErrorForRule(self::RULE_UNIQUE, ['field' => $this->getLabel($attr)]);
                }

                if($ruleName == self::RULE_APPROVAL){

                    foreach($this->registerApprovals as $approval) if($approval->required == 1 && !isset($this->approvals[$approval->id])) $this->addErrorForRule(self::RULE_APPROVAL);

                }
         
            }

        }

        return empty($this->errors);

    }

    private function addErrorForRule(string $rule, $replace = [])
    {

        $message = $this->errorMessages()[$rule] ?? '';
        foreach($replace as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[] = $message;

    }

    public function addError(string $message)
    {
        $this->errors[] = $message;
    }

    public function errorMessages()
    {

        return  [

            self::RULE_REQUIRED => 'Prosimy uzupełnić wszystkie dane',
            self::RULE_EMAIL => 'Podano niepoprawny adres e-mail',
            self::RULE_MIN => 'Minimalna ilość znaków - {min}',
            self::RULE_MAX => 'Maksymalna ilość znaków - {max}',
            self::RULE_MATCH => 'Hasła muszą być takie same {match}',
            self::RULE_UNIQUE => 'Taki {field} jest już zarejestrowany',
            self::RULE_APPROVAL => 'Należy zaakceptować wymagane zgody'

        ];

    }

    public function getFirstError()
    {
        return $this->errors[0] ?? false;
    }

}