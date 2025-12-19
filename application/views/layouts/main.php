<?php 
use ItForFree\SimpleMVC\Config;
use ItForFree\SimpleMVC\Router\WebRouter;

$User = Config::getObject('core.user.class');
$isAdmin = $User->isAllowed('admin/adminusers/index'); // Проверяем права доступа
?>
<!DOCTYPE html>
<html>
    <?php include('includes/main/head.php'); ?>
    <body> 
        <?php if ($isAdmin): ?>
        <div class="admin-link" style="padding: 10px; background: #f0f0f0; text-align: center;">
            <a href="<?= WebRouter::link('admin/adminusers/index') ?>" style="color: #d9534f; font-weight: bold;">
                Админка
            </a>
        </div>
        <?php endif; ?>
        
        <?php //include('includes/main/nav.php'); ?>
        <div class="container">
            <?= $CONTENT_DATA ?>
        </div>
        <?php include('includes/main/footer.php'); ?>
    </body>
</html>

