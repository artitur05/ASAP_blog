<?php include_once "./widgets/login.php"; ?>
<a href="./index.php">Главная</a>
<a href="./categories.php">Категории</a>
<a href="./about.php">О нас</a>
<?php if ($userName == 'admin'): ?>
    <a href="./admin/index.php">Админка</a>
<?php endif; ?>
<br>