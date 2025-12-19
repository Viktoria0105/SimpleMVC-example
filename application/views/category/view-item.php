<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-categories-nav.php'); ?>

<h2><?= $viewCategory->name ?>
    <span>
        <?= $User->returnIfAllowed("admin/categories/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/edit&id=". $viewCategory->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/categories/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/categories/delete&id=". $viewCategory->id)
            .    ">[Удалить]</a>"); ?>
    </span>
</h2> 

<p>Описание: <?= $viewCategory->description ?></p>
