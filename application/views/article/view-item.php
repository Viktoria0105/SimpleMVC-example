<?php
use ItForFree\SimpleMVC\Config;

$User = Config::getObject('core.user.class');
?>

<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $viewArticles->title ?>
    <span>
        <?= $User->returnIfAllowed("admin/articles/edit", 
            "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/edit&id=". $viewArticles->id) 
            . ">[Редактировать]</a>");?>
        
        <?= $User->returnIfAllowed("admin/articles/delete",
                "<a href=" . \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/delete&id=". $viewArticles->id)
            .    ">[Удалить]</a>"); ?>
    </span>
    
</h2> 

<p>Контент: <?= $viewArticles->content ?></p>
<p>Опубликована: <?= $viewArticles->publicationDate ?></p>
