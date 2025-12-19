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
        
        <h1>Widget News</h1>
        <p><a href="<?= WebRouter::link('archive/') ?>">Article Archive</a></p>
        
        <div class="articles-list">
            <?php foreach ($results['results'] as $article) { ?>
            <div class="article-item">
                <h2>
                    <span class="pubDate">
                        <?php echo date('j F Y', strtotime($article->publicationDate))?>
                    </span>
                    <?php echo htmlspecialchars($article->title)?>
                </h2>
                
                <div class="article-content">
                    <?php echo htmlspecialchars($article->shortContent)?>
                </div>
                
                <?php if(isset($results['authors'])) { ?>
                <div class="authors">
                    <?php
                    $authorsList = [];
                    foreach ($results['authors'] as $author) {
                        if (in_array($author->id, $article->authors)) {
                            $authorsList[] = htmlspecialchars($author->login);
                        }
                    }
                    echo implode(' ', $authorsList);
                    ?>
                </div>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        
        <p><?php echo count($results['results']) ?> articles in total.</p>
        <p><a href="/">Return to Homepage</a></p>
        
        <div id="footer">
            <a href="<?= WebRouter::link('admin/index') ?>">Site Admin</a>
        </div>
    </div>
</body>
</html>
