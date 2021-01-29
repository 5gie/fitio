<?php

namespace app\system;

use app\system\App;
use app\system\Model;
use PDOException;
use PDO;

abstract class DbModel extends Model
{

    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public static function primaryKey(): string;

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

            return self::lastInsertId();

        } catch(PDOException $e){
            error_log($e->getMessage());
            return false;
        }

    }

    public static function lastInsertId(): int
    {
        return App::$app->db->pdo->lastInsertId();
    }

    public function update($where)
    {

        try {

            $tableName = $this->tableName();
            $attributes = $this->attributes();
            $params = array_map(fn ($a) => "$a = :$a", $attributes);

            $query = implode(" AND ", array_map(fn ($attr) => "$attr = :$attr", array_keys($where)));

            $stmt = self::prepare("UPDATE $tableName SET " . implode(', ', $params) . " WHERE $query");

            foreach ($attributes as $attr) {
                $stmt->bindValue(":$attr", $this->{$attr});
            }

            foreach ($where as $key => $item) {
                $stmt->bindValue(":$key", $item);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $e) {

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

    public static function findAll($where = [], array $order = [], int $offset = 0, $limit = false)
    {
        $tableName = static::tableName();

        $query = '';

        $attributes = array_keys($where);
        if(!empty($where)) $query = " WHERE " . implode("AND ", array_map(fn ($attr) => "$attr = :$attr", $attributes));

        if (!empty($order)) foreach ($order as $item => $type) $query .= " ORDER BY $item $type";

        if ($limit) $query .= " LIMIT $offset, $limit";

        $stmt = self::prepare("SELECT * FROM $tableName $query");
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, static::class);
    }

}