<?php

namespace application\models;

use ItForFree\SimpleMVC\MVC\Model;

class Articles extends BaseExampleModel
{
    // Свойства
    public string $tableName = "articles";
    
    public string $orderBy = 'publicationDate ASC';
    
    /**
     * @var int ID статей из базы данных
     */
    public ?int $id = null;
    
    /**
     * @var int Дата первой публикации статьи
     */
    public $publicationDate = null;
    
    /**
     * @var string Полное название статьи
     */
    public $title = null;
    
    /**
     * @var int ID категории статьи
     */
    public $categoryId = null;
    
    /**
     * @var string Краткое описание статьи
     */
    public $summary = null;
    
    /**
     * @var string HTML содержание статьи
     */
    public $content = null;
    
    /**
     * @var bool Активна ли статья (отображается на главной)
     */
    public $active = true;
    
    /**
     * @var string Поле для задания №1 - 50 первых символов
     * поля content + "..."
     */
    public $shortContent = null;

    /**
     * Генерирует короткое содержание статьи
     */
    public function getShortContent()
    {
        $func = function($string, $start = 0, $length = 50, $trimmarker = '...'){
            $len = strlen(trim($string));
            $newstring = ( ($len >= $length) && ($len != 0) ) ? rtrim(mb_substr($string, $start, $length - strlen($trimmarker))) . $trimmarker : $string;
            return $newstring;
        };
        $this->shortContent = $func($this->content);
    }

    /**
     * Получает список статей по ID категории
     */
    public function getListByCategoryId($categoryId)
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tableName WHERE categoryId = :categoryId
                ORDER BY  $this->orderBy ";

        $modelClassName = static::class;

        $st = $this->pdo->prepare($sql);
        $st->bindValue( ":categoryId", $categoryId, \PDO::PARAM_INT );
        $st->execute();
        $list = array();

        while ($row = $st->fetch()) {
            $example = new $modelClassName($row);
            $list[] = $example;
        }

        $sql = "SELECT FOUND_ROWS() AS totalRows"; // получаем число выбранных строк
        $totalRows = $this->pdo->query($sql)->fetch();
        return (array ("results" => $list, "totalRows" => $totalRows[0]));
    }
    
    /**
     * Получает список статей с возможностью фильтрации
     */
    public function getList(int $numRows = 1000000, $params = []) : array
    {
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM $this->tableName";
        
        // Добавляем условие для активных статей, если указано
        if (isset($params['onlyActive']) && $params['onlyActive']) {
            $sql .= " WHERE active = 1";
        }
        
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
     * Вставка новой статьи
     */
    public function insert()
    {
        $sql = "INSERT INTO $this->tableName (publicationDate, title, categoryId, summary, content, active) 
                VALUES (:publicationDate, :title, :categoryId, :summary, :content, :active)"; 
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT);
        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
        $st->bindValue(":summary", $this->summary, \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_BOOL);
        
        $st->execute();
        $this->id = $this->pdo->lastInsertId();
    }
    
    /**
     * Обновление существующей статьи
     */
    public function update()
    {
        $sql = "UPDATE $this->tableName SET 
                publicationDate = :publicationDate, 
                title = :title, 
                categoryId = :categoryId, 
                summary = :summary, 
                content = :content,
                active = :active
                WHERE id = :id";  
        
        $st = $this->pdo->prepare($sql);
        $st->bindValue(":publicationDate", (new \DateTime('NOW'))->format('Y-m-d H:i:s'), \PDO::PARAM_STMT);
        $st->bindValue(":title", $this->title, \PDO::PARAM_STR);
        $st->bindValue(":categoryId", $this->categoryId, \PDO::PARAM_INT);
        $st->bindValue(":summary", $this->summary, \PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, \PDO::PARAM_STR);
        $st->bindValue(":active", $this->active, \PDO::PARAM_BOOL);
        $st->bindValue(":id", $this->id, \PDO::PARAM_INT);
        
        $st->execute();
    }
}