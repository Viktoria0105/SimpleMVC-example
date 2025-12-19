<?php
use ItForFree\SimpleMVC\Router\WebRouter;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статья</title>
    <link rel="stylesheet" href="/CSS/style.css"> <!-- Подключение CSS -->
</head>
<body>

<div id="container">
    <a href="/"><img id="logo" src="/images/logo.jpg" alt="Widget News" /></a>

    <div class="article-full">
        <?php if ($results['article']) { 
            $article = $results['article'];
        ?>
        
        <div class="article-summary">
            <i> <?php echo $article->summary?> </i>
        </div>

        <div class="article-content">
            <?php echo $article->content?>
        </div>

        <div class="pubDate">
            PUBLISHED ON <?php echo date('j F Y', strtotime($article->publicationDate))?>
            IN <?php echo htmlspecialchars($results['category']->name)?>
        </div>

        <?php if(isset($results['authors'])) { ?>
            <div class="authors">
                <strong>Авторы:</strong>
                <?php
                $authorsList = [];
                foreach ($results['authors'] as $author) {
                    if (in_array($author->id, $article->authors)) {
                        $authorsList[] = '<a href="' . WebRouter::link('viewArticleByAuthor', ['authorId' => $author->id]) . '">' . htmlspecialchars($author->login) . '</a>';
                    }
                }
                echo implode(', ', $authorsList);
                ?>
            </div>
        <?php } ?>
        
        <?php if (isset($article->subcategoryId)) { ?>
            <div class="subcategory">
                <strong>Подкатегория:</strong>
                <a href="<?= WebRouter::link('archive', ['subcategoryId' => $article->subcategoryId]) ?>">
                    <?php echo htmlspecialchars($results['subcategories'][$article->subcategoryId]->description)?>
                </a>
            </div>
        <?php } ?>
        
        <?php } else { ?>
            <p>Статья не найдена.</p>
        <?php } ?>
    </div>
    
    <p><a href="./">Вернуться на главную страницу</a></p>
</div>

</body>
</html>
