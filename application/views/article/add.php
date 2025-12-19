<style> 
    textarea{
        height: 200%;
        width: 1110px;
        color: #003300;
    }
</style>

<?php include('includes/admin-articles-nav.php'); ?>
<h2><?= $addArticleTitle ?></h2>

<form id="addArticle" method="post" action="<?= \ItForFree\SimpleMVC\Router\WebRouter::link("admin/articles/add")?>"> 
    <div class="form-group">
        <label for="title">Article Title</label>
        <input type="text" class="form-control" name="title" id="title" placeholder="Article title" required>
    </div>
    
    <div class="form-group">
        <label for="summary">Article Summary</label>
        <textarea class="form-control" name="summary" id="summary" placeholder="Article summary"></textarea>
    </div>
    
    <div class="form-group">
        <label for="content">Article Content</label>
        <textarea class="form-control" name="content" id="content" placeholder="Article content"></textarea>
    </div>
    
    <div class="form-group">
        <label for="categoryId">Article Category</label>
        <select class="form-control" name="categoryId" id="categoryId" required>
            <option value="">-- Выберите категорию --</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= htmlspecialchars($category->name) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="publicationDate">Publication Date</label>
        <input type="date" class="form-control" name="publicationDate" id="publicationDate">
    </div>
    
    <div class="form-group">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="active" id="active" value="1" checked>
            <label class="form-check-label" for="active">Статья активна (отображается на сайте)</label>
        </div>
    </div>
    
    <input type="submit" class="btn btn-primary" name="saveNewArticle" value="Сохранить">
    <input type="button" class="btn" name="cancel" value="Назад" onclick="window.history.back()">
</form>