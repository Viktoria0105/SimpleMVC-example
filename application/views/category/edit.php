<style> 
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
</style>

<?php 
use ItForFree\SimpleMVC\Config;

$Url = Config::getObject('core.router.class');
$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $editCategoryTitle ?></h2>

<form id="editCategory" method="post" action="<?= $Url::link("admin/categories/edit&id=" . $_GET['id'])?>">
    <h5>Название категории</h5> 
    <input type="text" name="name" placeholder="Название категории" value="<?= $viewCategory->name ?? '' ?>"><br>
    
    <h5>Описание категории</h5>
    <textarea name="description" placeholder="Описание категории"><?= $viewCategory->description ?? '' ?></textarea><br>

    <input type="hidden" name="id" value="<?= $_GET['id'] ?? '' ?>">
    <input type="submit" name="saveChanges" value="Сохранить">
    <input type="submit" name="cancel" value="Назад">
</form>
