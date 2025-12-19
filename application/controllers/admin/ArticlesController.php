<?php
namespace application\controllers\admin;
use application\models\Articles;
use application\models\Categories;
use ItForFree\SimpleMVC\Config;

/* 
 *   Class-controller articles
 * 
 * 
 */

class ArticlesController extends \ItForFree\SimpleMVC\MVC\Controller
{
    
    public string $layoutPath = 'admin-main.php';
    
    
    public function indexAction()
    {
        $Article = new Articles();

        $articleId = $_GET['id'] ?? null;
        
        if ($articleId) { // если указан конкретный материал
            $viewArticles = $Article->getById($_GET['id']);
            $this->view->addVar('viewArticles', $viewArticles);
            $this->view->render('article/view-item.php');
        } else { // выводим полный список
            
            $articles = $Article->getList()['results'];
            $this->view->addVar('articles', $articles);
            $this->view->render('article/index.php');
        }
    }
    
    /**
     * Выводит на экран форму для создания новой статьи (только для Администратора)
     */
    public function addAction()
    {
        $Url = Config::get('core.router.class');
        
        // Создаем экземпляр модели категорий
        $Categories = new Categories();
        
        // Получаем список всех категорий
        $categories = $Categories->getList()['results'];
        
        // Передаем категории в представление
        $this->view->addVar('categories', $categories);
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveNewArticle'])) {
                // Убедитесь, что active установлен
                $_POST['active'] = isset($_POST['active']) ? 1 : 0;
                
                $Article = new Articles();
                $newArticles = $Article->loadFromArray($_POST);
                $newArticles->insert(); 
                $this->redirect($Url::link("admin/articles/index"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/index"));
            }
        }
        else {
            $addArticleTitle = "Добавление новой статьи";
            $this->view->addVar('addArticleTitle', $addArticleTitle);
            
            // Также передаем пустой объект статьи для совместимости с формой
            $this->view->addVar('article', new Articles());
            
            $this->view->render('article/add.php');
        }
    }
    
    /**
     * Выводит на экран форму для редактирования статьи (только для Администратора)
     */
    public function editAction()
    {
        $id = $_GET['id'] ?? null;
        $Url = Config::get('core.router.class');
        
        // Загрузка категорий для выпадающего списка
        $Categories = new Categories();
        $categories = $Categories->getList()['results'];
        $this->view->addVar('categories', $categories);
        
        $Article = new Articles();
        $viewArticle = $Article->getById($id);
        
        if (!$viewArticle) {
            throw new Exception('Article not found');
        }
        
        if (!empty($_POST)) {
            if (!empty($_POST['saveChanges'])) {
                // Убедитесь, что active установлен
                $_POST['active'] = isset($_POST['active']) ? 1 : 0;
                
                $updatedArticle = $Article->loadFromArray($_POST);
                $updatedArticle->id = $id; // Убедитесь, что ID установлен
                $updatedArticle->update();
                $this->redirect($Url::link("admin/articles/index&id=$id"));
            } 
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/index&id=$id"));
            }
        }
        else {
            $editArticleTitle = "Редактирование статьи";
            
            $this->view->addVar('viewArticle', $viewArticle);
            $this->view->addVar('editArticleTitle', $editArticleTitle);
            
            $this->view->render('article/edit.php');   
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
            if (!empty($_POST['deleteArticle'])) {
                $Article = new Articles();
                $newArticles = $Article->loadFromArray($_POST);
                $newArticles->delete();
                
                $this->redirect($Url::link("admin/articles/index"));
              
            }
            elseif (!empty($_POST['cancel'])) {
                $this->redirect($Url::link("admin/articles/edit&id=$id"));
            }
        }
        else {
            
            $Article = new Articles();
            $deletedArticle = $Article->getById($id);
            $deleteArticleTitle = "Удалить статью?";
            
            $this->view->addVar('deleteArticleTitle', $deleteArticleTitle);
            $this->view->addVar('deletedArticle', $deletedArticle);
            
            $this->view->render('article/delete.php');
        }
    }
}
