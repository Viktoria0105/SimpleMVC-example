<?php


namespace application\models;


use ItForFree\SimpleMVC\mvc\Model;

class Categories extends BaseExampleModel
{
    // Свойства
    /**
     * @var int ID категории из базы данных
     */
    public ?int $id = null;
    /**
     * @var string Название категории
     */
    public $name = null;
    /**
     * @var string Короткое описание категории
     */
    public $description = null;
    /**
     * @var string Имя обрабатываемой таблицы
     */
    public string $tableName = 'categories';
    /**
     *  @var string Имя поля по котору сортируем
     */
    public string $orderBy = 'id ASC';

    /**
     * Возвращает список категорий
     */
    public function getList(int $numRows = 1000000): array
    {
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM categories
                  ORDER BY id ASC LIMIT :numRows";
        
        $st = $this->pdo->prepare($query);
        $st->bindValue(":numRows", $numRows, \PDO::PARAM_INT);
        $st->execute();
        
        $list = array();
        
        while ($row = $st->fetch()) {
            $category = new Categories();
            $category->id = $row['id'];
            $category->name = $row['name'];
            $category->description = $row['description'];
            $list[] = $category;
        }
        
        // Получаем общее количество строк
        $totalRows = $this->pdo->query("SELECT FOUND_ROWS()")->fetch();
        
        return array(
            "results" => $list,
            "totalRows" => $totalRows[0]
        );
    }
}