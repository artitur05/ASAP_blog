<?php
include dirname(__DIR__) . '/functions/auth.php';
include dirname(__DIR__) . "/functions/db.php";
if ($userName != 'admin') Die("Ты не пройдешь!");

$messages = [
    'del' => 'Пост удален',
    'add' => 'Пост добавлен',
    'edit' => 'Пост изменен',
    'error' => 'Ошибка',

];

$action = $_GET['action'] ?? '';
/*if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = '';
}*/

$message = !empty($_GET['status']) ? $messages[$_GET['status']] ?? '' : '';

$raw = [
    'id' => 0,
    'name' => ''
];
$formAction = "add";
$formText = "Добавить";


switch ($action) {
    case "add":
        $name = strip_tags($_POST['name']);
        $result = getConnection()->prepare("INSERT INTO categories (name) VALUES (?)");
        $result->execute([$name]);
        header("Location: ?status=add");
        die();

    case "delete":
        $id = (int)$_GET['id'];
        $result = getConnection()->prepare("DELETE FROM categories WHERE id = :id");
        $result->execute(['id' => $id]);
        header("Location: ?status=del");
        die();

    case "edit":
        $id = (int)$_GET['id'];
        $result = getConnection()->prepare("SELECT * FROM categories WHERE id = :id");
        $result->execute(['id' => $id]);
        $raw = $result->fetch();
        if (!$raw) {
            header("Location: ?status=error");
            die();
        }

        $formAction = "save";
        $formText = "Изменить";
        break;
    case "save":
        $name = strip_tags($_POST['name']);
        $id = (int)$_POST['id'];

        $result = getConnection()->prepare("UPDATE categories SET name = ? WHERE id = ?");
        $result->execute([$name, $id]);

        header("Location: ?status=edit");
        die();
    case "":
        break;
    default:
        header("Location: ?status=error");
        die();
}


$resultCategories = getConnection()->prepare("SELECT * FROM categories ORDER BY id DESC ");
$resultCategories->execute();
$categories = $resultCategories->fetchAll();


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php include dirname(__DIR__) . "/widgets/admin.php" ?>
<h2>Crud категории</h2>
<h3 style="color: red"><?= $message ?></h3>
<form action="?action=<?=$formAction?>" method="post">
    <input type="hidden" name="_method" value="delete">
    <input type="text" hidden name="id" value="<?=$raw['id']?>">
    <input type="text" placeholder="Имя новой категории" name="name" value="<?=$raw['name']?>">
    <input type="submit" value="<?=$formText?>">
</form>
<br>
<?php foreach($categories as $category): ?>
    <li><a href="/posts.php?id=<?=$category['id']?>"><?=$category['name']?></a>
        <a href="?id=<?= $category['id'] ?>&action=edit"><i class="fa fa-edit"></i></a>
        <a href="?id=<?= $category['id'] ?>&action=delete"><i class="fa fa-trash"></i></a>
    </li>
<?php endforeach;?>
</body>
</html>
