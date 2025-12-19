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

<?php include('includes/admin-articles-nav.php'); ?>

<h2><?= $editArticleTitle ?></h2>

<form id="editArticle" method="post" action="<?= $Url::link("admin/articles/edit&id=" . $_GET['id'])?>">
    <h5>Article Title</h5> 
    <input type="text" name="title" placeholder="Article title" value="<?= $viewArticle->title ?? '' ?>"><br>
    
    <h5>Article Summary</h5>
    <textarea name="summary" placeholder="Article summary"><?= $viewArticle->summary ?? '' ?></textarea><br>
    
    <h5>Article Content</h5>
    <textarea name="content" placeholder="Article content"><?= $viewArticle->content ?? '' ?></textarea><br>
    
    <h5>Article Category</h5>
    <select name="categoryId">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category->id ?>" <?= ($viewArticle->categoryId == $category->id) ? 'selected' : '' ?>>
                <?= $category->name ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <h5>Publication Date</h5>
    <input type="date" name="publicationDate" value="<?= isset($viewArticle->publicationDate) ? date('Y-m-d', strtotime($viewArticle->publicationDate)) : '' ?>"><br>
    <div class="checkbox-group">
                <input type="checkbox" id="active" name="active" checked>
                <label class="form-check-label" for="active">Статья активна (отображается на сайте)</label>
            </div>

    <input type="hidden" name="id" value="<?= $_GET['id'] ?? '' ?>">
    <input type="submit" name="saveChanges" value="Сохранить">
    <input type="submit" name="cancel" value="Назад">
</form>
