<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-articles-nav.php'); ?>

<h2>List articles</h2>

<?php if (!empty($articles)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Дата публикации</th>
      <th scope="col">Статья</th>
      <th scope="col">Категория</th>
      <th scope="col">Активность</th>
      <th scope="col"></th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($articles as $article): ?>
    <tr>
        <td> <?= $article->publicationDate ?> </td>
        <td> <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/articles/index&id=' 
        . $article->id . ">{$article->title}</a>" ) ?> </td>
        <td>
            <?php 
            $categoryModel = new \application\models\Categories();
            $category = $categoryModel->getById($article->categoryId);
            echo htmlspecialchars($category ? $category->name : 'Без категории');
            ?>
        </td>
        <td>
            <?php if ($article->active): ?>
                <span>Активна</span>
            <?php else: ?>
                <span>Неактивна</span>
            <?php endif; ?>
        </td>
    </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<?php else:?>
    <p> Список статей пуст</p>
<?php endif; ?>
