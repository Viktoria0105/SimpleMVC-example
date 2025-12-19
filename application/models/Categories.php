<?php

namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

class Categories extends BaseExampleModel
{
    // Свойства
    public string $tableName = "categories";
    
    public string $orderBy = 'id ASC';
    
    /**
     * @var int ID категории из базы данных
     */
    public ?int $id = null;
    
    /**
     * @var string Название категории
     */
    public $name = null;
    
    /**
     * @var string Описание категории
     */
    public $description = null;

    /**
     * Получает список категорий
     */
    public function getList(int $numRows = 1000000, $params = []) : array
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tableName";
        
        $sql .= " ORDER BY $this->orderBy LIMIT :numRows";

        $modelClassName = static::class;
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
        $st->execute();
        $list = array();

        while ($row = $st->fetch()) {
            $example = new $modelClassName($row);
            $list[] = $example;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $this->pdo->query($sql)->fetch();
        return array("results" => $list, "totalRows" => $totalRows[0]);
    }
    
    /**
     * Вставка новой категории
     */
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (name, description) 
                VALUES (:name, :description)"; 
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);
        
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    /**
     * Обновление существующей категории
     */
    public function update()
    {
        $sql = "UPDATE $this->tableName SET 
                name = :name, 
                description = :description
                WHERE id = :id";  
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":name", $this->name, \PDO::PARAM_STR);
        $st->bindValue(":description", $this->description, \PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        
        $st->execute();
    }
}
