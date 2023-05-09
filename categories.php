<?php
include __DIR__ . "/functions/db.php";
include __DIR__ . '/functions/auth.php';
$title = "Категории";
$result = getConnection()->query("SELECT * FROM categories");
$categories = $result->fetchAll();


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$title?></title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php include __DIR__ . "/widgets/menu.php"?>
    <b>Категории</b>
<ul>
<?php foreach($categories as $category): ?>
    <li><a href="./posts.php?id=<?=$category['id']?>"><?=$category['name']?></a></li>
<?php endforeach;?>
</ul>
</body>
</html>