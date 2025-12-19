<?php
namespace application\controllers\admin;
use application\models\Categories;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller categories
 * 
 * 
 */

class CategoriesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';
    
    
    public function indexAction()
    {
        $Category = new Categories();

        $categoryId = $_GET['id'] ?? null;
        
        if ($categoryId) { // если указана конкретная категория
            $viewCategory = $Category->getById($_GET['id']);
            $this->view->addVar('viewCategory', $viewCategory);
            $this->view->render('category/view-item.php');
        } else { // выводим полный список
            
            $categories = $Category->getList()['results'];
            $this->view->addVar('categories', $categories);
            $this->view->render('category/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой категории (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewCategory'])) {
                $Category = new Categories();
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->insert(); 
                $this->redirect($Url::link("admin/categories/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index"));
            }
        }
        else {
            $addCategoryTitle = "Добавление новой категории";
            $this->view->addVar('addCategoryTitle', $addCategoryTitle);
            
            // Также передаем пустой объект категории для совместимости с формой
            $this->view->addVar('category', new Categories());
            
            $this->view->render('category/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования категории (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        $Category = new Categories();
        $viewCategory = $Category->getById($id);
        
        if (!$viewCategory) {
            throw new Exception('Category not found');
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                $updatedCategory = $Category->loadFromArray($_POST);
                $updatedCategory->id = $id; // Убедитесь, что ID установлен
                $updatedCategory->update();
                $this->redirect($Url::link("admin/categories/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/index&id=$id"));
            }
        }
        else {
            $editCategoryTitle = "Редактирование категории";
            
            $this->view->addVar('viewCategory', $viewCategory);
            $this->view->addVar('editCategoryTitle', $editCategoryTitle);
            
            $this->view->render('category/edit.php');   
        }
    }
    
    /**
     * Выводит на экран предупреждение об удалении данных (только для Администратора)
     */
    public function deleteAction()
    {
        $id = $_GET['id'];
        $Url = Config::get('core.router.class');
        
        if (!empty($_POST)) {
            if (!empty($_POST['deleteCategory'])) {
                $Category = new Categories();
                $newCategory = $Category->loadFromArray($_POST);
                $newCategory->delete();
                
                $this->redirect($Url::link("admin/categories/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/categories/edit&id=$id"));
            }
        }
        else {
            
            $Category = new Categories();
            $deletedCategory = $Category->getById($id);
            $deleteCategoryTitle = "Удалить категорию?";
            
            $this->view->addVar('deleteCategoryTitle', $deleteCategoryTitle);
            $this->view->addVar('deletedCategory', $deletedCategory);
            
            $this->view->render('category/delete.php');
        }
    }
}