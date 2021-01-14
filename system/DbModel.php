<?php

namespace app\system;

use app\system\App;
use app\system\Model;
use PDOException;

abstract class DbModel extends Model
{

    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        try{
            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn ($a) => ":$a", $attributes);
            $stmt = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES(" . implode(',', $params) . ")");

            foreach ($attributes as $attr) {
                $stmt->bindValue(":$attr", $this->{$attr});
            }

            $stmt->execute();
            return true;
        } catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }


    }

    public static function prepare($sql)
    {
        return App::$app->db->pdo->prepare($sql);
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $query = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));

        $stmt = self::prepare("SELECT * FROM $tableName WHERE $query");
        foreach($where as $key => $item){
            $stmt->bindValue(":$key", $item);
        }

        $stmt->execute();
        return $stmt->fetchObject(static::class);

    }

}