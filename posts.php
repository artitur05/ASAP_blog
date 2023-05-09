<?php
include __DIR__ . "/functions/db.php";
include __DIR__ . '/functions/auth.php';
$title = "Посты категории";
$category_id = !empty($_GET['id'])? (int)$_GET['id']:0;


$result = getConnection()->prepare("SELECT posts.id, posts.title, categories.name FROM posts 
    INNER JOIN categories ON posts.category_id = categories.id WHERE category_id = :id");

$result->execute(['id' => $category_id]);

$posts = $result->fetchAll();

$categoryName = !empty($posts)? $posts[0]['name']:"Нет такой категории";
/*if (!empty($posts)) {
    $categoryName = $posts[0]['name'];
} else {
    $categoryName = "Нет такой категории";
}*/
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
<b>Посты категории <?=$categoryName?></b>
<ul>
    <?php foreach($posts as $post): ?>
        <li><a href="./post.php?id=<?=$post['id']?>"><?=$post['title']?></a></li>
    <?php endforeach;?>
</ul>
</body>
</html>