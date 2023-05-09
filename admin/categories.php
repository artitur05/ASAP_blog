<?php
include dirname(__DIR__) . '/functions/auth.php';
include_once dirname(__DIR__) . "/functions/db.php";
if ($userName != 'admin') Die("Ты не пройдешь!");

$messages = [
    'del' => 'Пост удален',
    'add' => 'Пост добавлен',
    'edit' => 'Пост изменен',
    'error' => 'Ошибка',

];

$action = $_GET['action'] ?? '';


$message = !empty($_GET['status']) ? $messages[$_GET['status']] ?? '' : '';

$raw = [
    'id' => 0,
    'name' => ''
];
$formAction = "add";
$formText = "Добавить";





//CRUD edit
if (!empty($_GET['action']) and $_GET['action'] == 'edit') {
    $id = (int)$_GET['id'];
    $result = getConnection()->prepare("SELECT * FROM categories WHERE id = :id");
    $result->execute(['id'=>$id]);
    $raw = $result->fetch();
    $action = "save";
    $formText = "Изменить";
}

if (!empty($_GET['action']) and $_GET['action'] == 'save') {
    $title = strip_tags($_POST['title']);
    $id = (int)$_POST['id'];

    $result = getConnection()->prepare('UPDATE categories SET name = ? WHERE id = ?');
    $result->execute([$title, $id]);

    header("Location: /admin?status=edit");
    die();
}
//CRUD create
if (!empty($_POST) and $_GET['action'] == 'add')
{
    $title = strip_tags($_POST['title']);


    $result = getConnection()->prepare('INSERT INTO categories (name) VALUES (?)');
    $result->execute([$title]);

    header("Location: /admin?status=add");
    die();
}


//CRUD delete
if(!empty($_GET['action']) and $_GET['action']== 'delete')
{
    $id = (int)$_GET['id'];
    $result = getConnection()->prepare("DELETE FROM categories WHERE id = :id");
    $result->execute(['id'=>$id]);

    header("Location: /admin?status=del");
    die();

}
//  CRUD read
$result = getConnection()->prepare('SELECT id,name FROM categories ORDER BY id DESC');
$result->execute();
$categories = $result->fetchAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
        <a href="?id=<?= $category['id'] ?>&action=edit"><i>Редактировать</i></a>
        <a href="?id=<?= $category['id'] ?>&action=delete"><i>Удалить</i></a>
    </li>
<?php endforeach;?>
</body>
</html>
