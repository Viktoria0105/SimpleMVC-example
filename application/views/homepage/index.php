<?php
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$isHomePage = $_SERVER['REQUEST_URI'] == '/' || basename($_SERVER['SCRIPT_NAME']) == 'index.php';
$bodyClass = $isHomePage ? 'home-page' : '';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Widget News</title>
    <link rel="stylesheet" href="/CSS/style.css">
</head>
<body class="<?= $bodyClass ?>">
    <div id="container">
        <a href="/"><img id="logo" src="/images/logo.jpg" alt="Widget News" /></a>
    <ul id="headlines">
    
    <div>
    <a href="<?= \ItForFree\SimpleMVC\Router\WebRouter::link('admin/adminusers/index') ?>">
    </div>

    <div class="row">
        <?php foreach ($results['results'] as $article) { 
            // Пропускаем неактивные статьи на главной странице
            if ($isHomePage && !$article->active) {
                continue;
            }
        ?>
        <li class='<?php echo $article->id?>'>
            <h2>
                    <span class="pubDate">
                        <?php echo date('j F', strtotime($article->publicationDate))?>
                    </span>

                
                <a href="<?= WebRouter::link("viewArticle/&id=".$article->id)?>">
                    <?php echo htmlspecialchars($article->title)?>
                </a>

                <?php if (isset($article->categoryId)) { ?>
                    <span class="category">
                            in
                            <a href=".?action=archive&amp;categoryId=<?php echo $article->categoryId?>">
                                <?php echo htmlspecialchars($results['categories'][$article->categoryId]->name)?>
                            </a>
                        </span>
                    <?php } ?>
                </h2>
                <p class="summary<?php echo $article->id?>"><?php echo htmlspecialchars($article->shortContent)?></p>
                <ul class="ajax-load">
                    <li><a href="<?= WebRouter::link("viewArticle/&id=".$article->id)?>" class="ajaxArticleBodyByPost" data-contentId="<?php echo $article->id?>">Показать продолжение (POST)</a></li>
                    <li><a href="<?= WebRouter::link("viewArticle/&id=".$article->id)?>" class="ajaxArticleBodyByGet" data-contentId="<?php echo $article->id?>">Показать продолжение (GET)</a></li>
                    <li><a href="<?= WebRouter::link("viewArticle/&id=".$article->id)?>" class="newAjaxPost" data-contentId="<?php echo $article->id?>">(POST) -- NEW</a></li>
                    <li><a href="<?= WebRouter::link("viewArticle/&id=".$article->id)?>" class="newAjaxGet" data-contentId="<?php echo $article->id?>" >(GET)  -- NEW</a></li>
                </ul>
                <a href="<?= WebRouter::link("viewArticle/&id=".$article->id)?>" class="showContent" data-contentId="<?php echo $article->id?>">Показать полностью</a>
                <?php if(isset($results['authors'])) { ?>
                <span class="category">
                    <?php
                    $res = "";
                    foreach ($results['authors'] as $author) {
                        if (in_array($author->id, $article->authors)) {
                            ?>
                            <a href="/viewArticleByAuthor?authorId=<?php echo (in_array($author->id, $article->authors)) ? $author->id : "0"; ?>"><?php echo(in_array($author->id, $article->authors)) ? htmlspecialchars($author->login) : ""; ?></a>
                        <?php }
                    }
                    ?>
                </span>
                <?php } ?>
        </li>
        <?php } ?>
    </ul>

        <div id="footer">
            
        </div>
    </div>
</body>
</html>