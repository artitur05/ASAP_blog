<?php
include __DIR__ . "/functions/db.php";
include __DIR__ . '/functions/auth.php';
$title = "Пост";

$post_id = !empty($_GET['id']) ? (int)$_GET['id'] : 0;

$result = getConnection()->prepare("SELECT posts.title,posts.text,categories.name, posts.image FROM posts 
    INNER JOIN  categories ON posts.category_id = categories.id WHERE posts.id = :id");

$result->execute(['id' => $post_id]);

$post = $result->fetch();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<?php include __DIR__ . "/widgets/menu.php" ?>
<?php if (!empty($post)): ?>
    <b>Пост категории <?= $post['name'] ?></b>
    <h2><?= $post['title'] ?></h2>
    <?php if (!is_null($post['image'])): ?>
        <img class="post-img" src="/images/<?= $post['image'] ?>" alt="" width="200">
    <?php endif; ?>
    <p><?= $post['text'] ?></p>
<?php else: ?>
    Нет такого поста
<?php endif; ?>
</body>
</html>