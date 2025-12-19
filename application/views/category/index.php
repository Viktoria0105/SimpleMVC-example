<?php 
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>
<?php include('includes/admin-categories-nav.php'); ?>

<h2>Список категорий</h2>

<?php if (!empty($categories)): ?>
<table class="table">
    <thead>
    <tr>
      <th scope="col">Название</th>
      <th scope="col">Описание</th>
    </tr>
     </thead>
    <tbody>
    <?php foreach($categories as $category): ?>
    <tr>
        <td> 
            <?= "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link('admin/categories/index&id=' 
            . $category->id . ">{$category->name}</a>" ) ?> 
        </td>
        <td> <?= htmlspecialchars($category->description) ?> </td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php else:?>
    <p>Список категорий пуст</p>
<?php endif; ?>
